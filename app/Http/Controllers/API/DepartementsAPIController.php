<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departements;
use App\Repositories\DepartementsRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class DepartementsAPIController extends Controller
{
    /** @var  DepartementsRepository */
    private $departementsRepository;

    public function __construct(DepartementsRepository $departementsRepo)
    {
        $this->departementsRepository = $departementsRepo;
    }

    /**
     * Display a listing of the Category.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
//        $cache_key = 'category_';
        try {
            $this->departementsRepository->pushCriteria(new RequestCriteria($request));
            $this->departementsRepository->pushCriteria(new LimitOffsetCriteria($request));


        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        $projects = $this->departementsRepository->all();

//        Cache::forget($cache_key);
//        if (!Cache::has($cache_key)) {
//            $projects = Projects::get();
//            $projects->each(function ($c) {
//                $this->cleanCollection($c);
//            });
//            Cache::put($cache_key, $projects);
//        } else {
//            $projects = Cache::get($cache_key);
//        }

        return $this->sendResponse($projects, 'Projects retrieved successfully');
    }


    /**
     * Display the specified Category.
     * GET|HEAD /categories/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
//        $cache_key = 'project_' . $id;
        /** @var Departements $projects */
        if (!empty($this->departementsRepository)) {
            try {
                $this->departementsRepository->pushCriteria(new RequestCriteria($request));
                $this->departementsRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }

            $project = $this->departementsRepository->findWithoutFail($id);
        }
        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        return $this->sendResponse($project->toArray(), 'Project retrieved successfully');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try {
            $project = $this->departementsRepository->create($input);

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($project->toArray(), __('lang.saved_successfully'));
    }

    /**
     * Update the specified Category in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $project = $this->departementsRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }
        $input = $request->all();
        try {
            $project = $this->departementsRepository->update($input, $id);

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($project->toArray(), __('lang.updated_successfully'));

    }

    /**
     * Remove the specified Category from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $project = $this->departementsRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        $project = $this->departementsRepository->delete($id);

        return $this->sendResponse($project, __('lang.deleted_successfully'));
    }
}
