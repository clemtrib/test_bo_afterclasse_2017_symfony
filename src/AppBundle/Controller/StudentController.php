<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Student;

class StudentController extends Controller
{

    /**
     * LIST
     * @return Response
     */
    public function getStudentsAction()
    {

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $students = $repository->findAll();

        $formatted = array();

        foreach ($students as $student) {
            $formatted[] = array(
                'id' => $student->getId(),
                'firstname' => $student->getFirstname(),
                'lastname' => $student->getLastname(),
                'address1' => $student->getAddress1(),
                'address2' => $student->getAddress2(),
                'postcode' => $student->getPostcode(),
                'city' => $student->getCity(),
                'email' => $student->getEmail(),
                'phone' => $student->getPhone()
            );
        }

        $response = $this->formatResponse($formatted);
        return $response;

    }

    /**
     * VIEW
     * @param Request $request
     * @return Response
     */
    public function getStudentAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $student = $repository->find($request->get('id'));

        if (empty($student)) {
            $response = $this->formatResponse(['message' => "Student #{$request->get('id')} not found"], Response::HTTP_NOT_FOUND);
            return $response;
        }

        $response = $this->formatResponse(
            array(
                'id' => $student->getId(),
                'firstname' => $student->getFirstname(),
                'lastname' => $student->getLastname(),
                'address1' => $student->getAddress1(),
                'address2' => $student->getAddress2(),
                'postcode' => $student->getPostcode(),
                'city' => $student->getCity(),
                'email' => $student->getEmail(),
                'phone' => $student->getPhone()
            )
        );

        return $response;

    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function optionsStudentAction(Request $request)
    {
        $response = $this->formatResponse(array('message' => ''));
        return $response;
    }


    /**
     * DELETE A STUDENT
     * @param Request $request
     * @return Response
     */
    public function deleteStudentAction(Request $request)
    {
        $content = (array)json_decode($request->getContent());

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $student = $repository->find($content['id']);

        if (empty($student)) {
            $response = $this->formatResponse(['message' => "Student #{$content['id']} not found"], Response::HTTP_NOT_FOUND);
            return $response;
        }

        try {

            $em = $this->getDoctrine()->getManager();
            $em->remove($student);
            $em->flush();

            $response = $this->formatResponse(array('message' => "Student #{$content['id']} deleted"));
        } catch (Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            $response = $this->formatResponse(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return $response;
    }

    /**
     * CREATE A STUDENT
     * @param Request $request
     * @return Response
     */
    public function putStudentAction(Request $request)
    {
        try {
            $student = new Student((array)json_decode($request->getContent()));
            $student->setPassword(rand(1000, 999999));
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            $response = $this->formatResponse(array('message' => "Student #{$student->getId()} created"));
        } catch (Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            $response = $this->formatResponse(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $response;
    }

    /**
     * UPDATE A STUDENT
     * @param Request $request
     * @return Response
     */
    public function patchStudentAction(Request $request)
    {

        $content = (array)json_decode($request->getContent());

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $student = $repository->find($content['id']);

        if (empty($student)) {
            $response = $this->formatResponse(['message' => "Student #{$content['id']} not found"], Response::HTTP_NOT_FOUND);
            return $response;
        }

        try {
            $student->hydrate($content);

            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            $response = $this->formatResponse(array('message' => "Student #{$student->getId()} updated"));
        } catch (Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            $response = $this->formatResponse(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    /**
     * SEND A JSON RESPONSE
     * @param $msg
     * @param null $status
     * @return Response
     */
    private function formatResponse($msg, $status = null)
    {
        $response = new Response();
        $response->setContent(json_encode($msg))->setStatusCode($status ?? Response::HTTP_OK);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        return $response;
    }

}
