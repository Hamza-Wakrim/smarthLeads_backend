<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Designations;
use App\Models\Projects;
use App\Models\UserProjects;
use App\Repositories\DesignationRepository;
use App\Repositories\ProjectsRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class DesignationsAPIController extends Controller
{
    /** @var  DesignationRepository */
    private $designationRepository;

    public function __construct(DesignationRepository $designationRepo)
    {
        $this->designationRepository = $designationRepo;
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
            $this->designationRepository->pushCriteria(new RequestCriteria($request));
            $this->designationRepository->pushCriteria(new LimitOffsetCriteria($request));


        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        $projects = $this->designationRepository->all();

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
        /** @var Designations $projects */
        if (!empty($this->designationRepository)) {
            try {
                $this->designationRepository->pushCriteria(new RequestCriteria($request));
                $this->designationRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }

            $project = $this->designationRepository->findWithoutFail($id);
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
            $project = $this->designationRepository->create($input);

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
        $project = $this->designationRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }
        $input = $request->all();
        try {
            $project = $this->designationRepository->update($input, $id);

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
        $project = $this->designationRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        $project = $this->designationRepository->delete($id);

        return $this->sendResponse($project, __('lang.deleted_successfully'));
    }
}
