<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Todo;

/**
 * En esta clase deben implementar los metodos vacios de acuerdo a lo
 * previamente estudiado acerca de RESTFul. Recuerda que DEBEN validar los datos
 * de entrada y de regresar lo que les pide el método correctamente.
 *
 * Class TodoController
 * @package App\Http\Controllers
 */
class TodoController extends Controller
{
    /**
     * Este método del controlador regresa el listado del todos de la app
     * en un response del tipo json ordenados desde el más antiguo al más nuevo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Todo::orderBy('created_at', 'DESC')->get();
        return $tasks;
    }

    /**
     * Este método del controlador debe crear un nuevo registro todo
     * y al final regresa el registro creado en un response del tipo
     * json.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        /**
         * Se realiza la validación de los datos recibidos (text, done).
         */
        $this->validate($request,[
            'text' => ['required'],
            'done' => ['required','boolean']

        ]);

        /**
         * Se realiza el insert a la BDD.
         */
        $task = new Todo;
        $task->text = $request->text;
        $task->done = $request->done;
        $task->save();

        return $task;
    }

    /**
     * Modifica el item todo con el $id correspondiente
     * y regresa el mismo item modificado.
     *
     * @param integer $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        /**
         * Se realiza la validación de los datos recibidos (id).
         */
        $this->validate($request,[
            'id' => 'required'
        ]);

        $task = Todo::find($id);

        /**
         * Se realiza el update del done inverso del booleano
         */
        if( $task->done == 0 )
        {
            $task->done = 1;
        } else {
            $task->done = 0;
        }

        $task->save();

        return $task;
    }

    /**
     * Elimina el registro y devuelve un response 200 en caso de exito o un 400
     * en caso de fallo pero igual en tipo json.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $task = Todo::findOrFail($id)->delete();
            $response = '{"response" : 200}';
        } catch (ModelNotFoundException $exception ) {
            $response = '{"response" : 400}';
        }

        return $response;
    }
}
