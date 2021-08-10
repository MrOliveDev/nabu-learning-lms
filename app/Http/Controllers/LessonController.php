<?php

namespace App\Http\Controllers;

use App\Models\CursoModel;
use Illuminate\Http\Request;
use App\Models\LessonsModel;
use App\Models\TrainingsModel;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = LessonsModel::all();

        return response()->json($lessons);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lesson = new LessonsModel();

        if ($request->post('lesson_name')) {
            $lesson->name = $request->post('lesson_name');
        }
        if ($request->post('lesson_duration')) {
            $lesson->duration = $request->post('lesson_duration');
        }
        if ($request->post('lesson_description')) {
            $lesson->description = $request->post('lesson_description');
        }
        if ($request->post('lesson_enddate')) {
            $lesson->date_end = $request->post('lesson_enddate');
        }
        if ($request->post('lesson_target')) {
            $lesson->publicAudio = $request->post('lesson_target');
        }
        if ($request->post('lesson_language')) {
            $lesson->lang = $request->post('lesson_language');
        }
        if ($request->post('lesson_status')) {
            $lesson->status = $request->post('lesson_status');
        }
        if (auth()->user()->type !== 0) {
            $lesson->idCreator = auth()->user()->id;
        } else {
            $lesson->idCreator = session("client");
        }
        $lesson->idFabrica = $this->randomGenerate();
        $lesson->save();

        // $curso = new CursoModel();

        // if ($request->post('lesson_name')) {
        //     $curso->nome = $request->post('lesson_name');
        // }
        // if ($request->post('lesson_description')) {
        //     $curso->descricao = $request->post('lesson_description');
        // }
        // if ($request->post('lesson_enddate')) {
        //     $curso->dataCriacao = $request->post('lesson_enddate');
        // }
        // if ($request->post('lesson_target')) {
        //     $curso->publicoAlvo = $request->post('lesson_target');
        // }
        // if ($request->post('lesson_status')) {
        //     $curso->status = $request->post('lesson_status');
        // }
        // if ($request->post('threshold-score')) {
        //     $curso->threshold_score = $request->post('threshold-score');
        // }
        // $curso->idFabrica = $lesson->idFabrica;
        // $curso->idCriador = 1;
        // $curso->save();

        return response()->json(LessonsModel::getLessonContainedTraining($lesson->id));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = LessonsModel::getLessonForTrainingpage($id);

        return response()->json($lesson);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lesson = LessonsModel::find($id);

        if ($request->post('lesson_name')) {
            $lesson->name = $request->post('lesson_name');
        }
        if ($request->post('lesson_duration')) {
            $lesson->duration = $request->post('lesson_duration');
        }
        if ($request->post('lesson_description')) {
            $lesson->description = $request->post('lesson_description');
        }
        if ($request->post('lesson_enddate')) {
            $lesson->date_end = $request->post('lesson_enddate');
        }
        if ($request->post('lesson_target')) {
            $lesson->publicAudio = $request->post('lesson_target');
        }
        if ($request->post('lesson_language')) {
            $lesson->lang = $request->post('lesson_language');
        }
        if ($request->post('lesson_status')) {
            $lesson->status = $request->post('lesson_status');
        }
        if ($request->post('threshold-score')) {
            $lesson->threshold_score = $request->post('threshold-score');
        }
        $lesson->update();

        // $curso = CursoModel::find($id);
        // if (isset($curso)) {
        //     if ($request->post('lesson_name')) {
        //         $curso->nome = $request->post('lesson_name');
        //     }
        //     if ($request->post('lesson_description')) {
        //         $curso->descricao = $request->post('lesson_description');
        //     }
        //     if ($request->post('lesson_target')) {
        //         $curso->publicoAlvo = $request->post('lesson_target');
        //     }
        //     if ($request->post('lesson_status')) {
        //         $curso->status = $request->post('lesson_status');
        //     }
        //     if ($request->post('threshold-score')) {
        //         $curso->threshold_score = $request->post('threshold-score');
        //     }
        //     $curso->update();
        // }
        return response()->json(LessonsModel::getLessonContainedTraining($lesson->id));
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = LessonsModel::find($id);

        $lesson->delete();

        return response()->json($id);
        //
    }

    public function getTrainingFromLesson($id)
    {
        $templesson = LessonsModel::getLessonContainedTraining($id);
        if (isset($templesson['training'])) {
            $trainingList = [];
            foreach ($templesson['training'] as $trainingId) {
                if (TrainingsModel::find($trainingId)) {
                    if (!in_array(TrainingsModel::getTrainingForTrainingpage($trainingId), $trainingList)) {
                        array_push($trainingList, TrainingsModel::getTrainingForTrainingpage($trainingId));
                    }
                }
            }

            $response = json_encode([
                'isSuccess' => true,
                'data'  => $trainingList
            ]);

            return $response;
            // return response()->json($trainingList);
        } else {
            return response()->json([]);
        }
    }

    public function randomGenerate($car = 8)
    {
        $string = "";
        $chaine = "ABCDEFGHIJQLMNOPQRSTUVWXYZabcdefghijqlmnopqrstuvwxyz0123456789";
        srand((float) microtime() * 1000000);
        for ($i = 0; $i < $car; $i++) {
            $string .= $chaine[rand() % strlen($chaine)];
        }
        return $string;
    }
}
