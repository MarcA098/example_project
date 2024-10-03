<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class NurseController extends AbstractController
{
    // Ruta para el endpoint
    #[Route('/nurse/search', name: 'app_nurse_search')]
    public function search(Request $request): JsonResponse
    {
        $json = '[{"id":1,"first_name":"Tyne","last_name":"Furby","email":"tfurby0@multiply.com"},
        {"id":2,"first_name":"Madeline","last_name":"Skittrell","email":"mskittrell1@dot.gov"},
        {"id":3,"first_name":"Derron","last_name":"McEnhill","email":"dmcenhill2@nhs.uk"},
        {"id":4,"first_name":"Persis","last_name":"Hayer","email":"phayer3@yellowbook.com"},
        {"id":5,"first_name":"Wallie","last_name":"Polgreen","email":"wpolgreen4@furl.net"}]';
        
        // Decodificar el JSON a un array asociativo
        $nurseArray = json_decode($json, true);

        // Asignar a la varible el parámetro de búsqueda 'name'
        $searchName = $request->query->get('name');

        // Filtrar enfermeros ya sea por nombre o apellido
        $filteredNurses = array_filter($nurseArray, function ($nurse) use ($searchName) {
            return stripos($nurse['first_name'], $searchName) !== false || 
                   stripos($nurse['last_name'], $searchName) !== false;
        });

        // Verificar la búsqueda
        if (empty($filteredNurses)) {
            // Respuesta JSON con el mensaje de no encontrado
            return $this->json(['message' => 'Enfermer@ no encontrad@']);
        }

        // Jason con los datos encontrados
        return $this->json(array_values($filteredNurses));
    }
}
