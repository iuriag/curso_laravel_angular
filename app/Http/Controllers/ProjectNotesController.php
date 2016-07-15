<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use CodeProject\Http\Requests\ProjectNoteCreateRequest;
use CodeProject\Http\Requests\ProjectNoteUpdateRequest;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;


class ProjectNotesController extends Controller
{

    /**
     * @var ProjectNoteRepository
     */
    protected $repository;

    /**
     * @var ProjectNoteValidator
     */
    protected $validator;


    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idProject)
    {

        $projectNotes = $this->repository->findWhere(['project_id' => $idProject]);
            return response()->json([
                'data' => $projectNotes,
            ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('projectNotes.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectNoteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectNoteCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $projectNote = $this->repository->create($request->all());

            $response = [
                'message' => 'ProjectNote created.',
                'data'    => $projectNote->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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
        $projectNote = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $projectNote,
            ]);
        }

        return view('projectNotes.show', compact('projectNote'));
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

        $projectNote = $this->repository->find($id);

        return view('projectNotes.edit', compact('projectNote'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectNoteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ProjectNoteUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $projectNote = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ProjectNote updated.',
                'data'    => $projectNote->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'ProjectNote deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ProjectNote deleted.');
    }
}
