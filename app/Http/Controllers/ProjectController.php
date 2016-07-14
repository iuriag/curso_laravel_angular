<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Client;
use CodeProject\Entities\User;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use CodeProject\Http\Requests\ProjectCreateRequest;
use CodeProject\Http\Requests\ProjectUpdateRequest;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;


class ProjectController extends Controller
{

    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
    protected $validator;


    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $projects = $this->repository->all();


            return response()->json([
                'data' => $projects,
            ]);

    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail();

            $project = $this->repository->create($request->all());

            $response = [
                'message' => 'Project created.',
                'data'    => $project->toArray(),
            ];
            return response()->json($response);

        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = $this->repository->with(['owner', 'client'])->find($id);


            return response()->json([
                'data' => $project,
            ]);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $project = $this->repository->find($id);

        return view('projects.edit', compact('project'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $project = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Project updated.',
                'data'    => $project->toArray(),
            ];


                return response()->json($response);

        } catch (ValidatorException $e) {


                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return response()->json([
            'message' => 'Project deleted.',
            'deleted' => $deleted,
        ]);

    }
}
