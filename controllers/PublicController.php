<?php
namespace Controllers;

use MVC\Router;
use Model\ActiveRecord;
use Model\Contacto;

class PublicController
{
    public static function index(Router $router)
    {
        $router->render("public/index",
        [
            "contacts" => Contacto::all()
        ]);
    }

    public static function crear()
    {
        $contact = [];
        $accion = $_POST["accion"] ?? "";

        if($accion === "crear")
        {
            $contact = new Contacto($_POST);
            $contact->errors = $contact->verify();

            if(empty($contact->errors))
            {
                if($contact->save()) 
                {
                    $contact->id = $contact->insert_id();
                    $contact->response = 200;
                }
                else 
                {
                    $contact->errors[] = "No se pudo guardar el contacto";
                    $contact->response = 500;
                }
            }
            else $contact->response = 400;
        }
        echo json_encode($contact);
    }

    public static function editar()
    {
        $contact = new Contacto($_POST);

        if(filter_var($_POST["id"] ?? "NaN", FILTER_VALIDATE_INT))
        {
            $contact->errors = $contact->verify();
            if(empty($contact->errors))
            {
                if($contact->update()) $contact->response = 100;
                else $contact->response = 500;
            }
            else $contact->response = 400;
        }
        else $contact->response = 400;

        echo json_encode($contact);
    }

    public static function eliminar()
    {
        $id = filter_var($_POST["id"] ?? "NaN", FILTER_VALIDATE_INT);
        $contact = new Contacto(["id" => $id]);
        $response = 0;

        if($id)
        {
            if($contact->delete()) $response = 100;
            else $response = 500;
        }
        else $response = 400;

        echo json_encode($response);
    }
}