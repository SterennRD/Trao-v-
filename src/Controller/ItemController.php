<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Item;
use App\Entity\Status;
use App\Form\CommentType;
use App\Form\ItemType;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Form;


/**
 * @Route("/item")
 */
class ItemController extends AbstractController
{
    /**
     * @Route("/", name="item_index", methods="GET")
     */
    public function index(): Response
    {
        $items = $this->getDoctrine()
            ->getRepository(Item::class)
            ->findAll();

        return $this->render('item/index.html.twig', ['items' => $items]);
    }

    /**
     * @Route("/new", name="item_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $item->setUser($this->getUser());
            $status = $this->getDoctrine()->getRepository(Status::class)->find($request->get("status_id"));
            if (!$status) {
                throw new HttpException(500, "Statut incorrect");
            }
            $item->setStatus($status);
            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            $file = $form->get('photo')->getData();

            if (!$file) {

            } else {
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('photo_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents
                $item->setPhoto($fileName);
            }



            // ... persist the $product variable or any other work


            $item->setCreatedAt(new \DateTime());
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('item_index');
        }

        $statusFound = $this->getDoctrine()->getRepository(Status::class)->findOneBy(["label" => Status::FOUND]);
        $statusLost = $this->getDoctrine()->getRepository(Status::class)->findOneBy(["label" => Status::LOST]);
        $type = $request->get('type');

        return $this->render('item/new.html.twig', [
            'item' => $item,
            'formLost' => $form->createView(),
            'formFound' => $form->createView(),
            'statusFound' => $statusFound,
            'statusLost' => $statusLost,
            'type' => $type,
        ]);
    }


    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/show/{id}", name="item_show", methods="GET|POST")
     */
    public function show(Item $item, Request $request): Response
    {
        $id = $item->getId();
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findByItem($id);

        $comment = new Comment;
        $comment -> setItem($item);
        $comment->setUser($this->getUser());
        $comment->setCreatedAt(new \DateTime());
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $comment->setContent($form->get('content')->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('item/show.html.twig', [
            'item' => $item,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="item_edit", methods="GET|POST")
     */
    public function edit(Request $request, Item $item): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_index', ['id' => $item->getId()]);
        }

        return $this->render('item/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_delete", methods="DELETE")
     */
    public function delete(Request $request, Item $item): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
        }

        return $this->redirectToRoute('item_index');
    }

    /**
     * @Route("/city/{city}", name="item_city")
     */
    public function findByCity(string $city) : Response
    {
        $items = $this->getDoctrine()->getRepository(Item::class)->findBy(["city" => $city]);

        return $this->render('item/city.html.twig', [
            "items" => $items,
            "city" => $city
        ]);
    }

    /**
     * @Route("/list/{status}", name="item_list")
     */
    public function findByStatus(string $status) : Response
    {
        $items = $this->getDoctrine()->getRepository(Item::class)->findByStatus($status);

        return $this->render('item/list.html.twig', [
            "items" => $items,
            "status" => $status
        ]);
    }

    /**
     * @Route("/search", name="item_search")
     */
    public function search(Request $request): Response
    {
        $item = new Item();
        $form = $this->createFormBuilder($item)
            ->add('category')
            ->add('county')
            ->add('dateBegin', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $category = $data->getCategory()->getId();
            $county = $data->getCounty()->getId();
            $date = null;
            if ($data->getDateBegin()) {
                $date = $data->getDateBegin()->format('Y-m-d');
            }
            return $this->redirectToRoute('item_search_results', [
                'category' => $category,
                'county' => $county,
                'date' => $date
            ]);
        }


        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('item/search.html.twig', [

            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search/results", name="item_search_results")
     */
    public function searchResults(Request $request): Response
    {
        $category = $request->get('category');
        $county = $request->get('county');
        $date = $request->get('date');
        $items = $this->getDoctrine()->getRepository(Item::class)->findBySearch($category, $county, $date);

        return $this->render('item/search-results.html.twig', [

            'items' => $items,
        ]);
    }
}
