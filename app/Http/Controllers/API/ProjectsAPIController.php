<?php
/**
 * File name: CategoryAPIController.php
 * Last modified: 2020.05.04 at 09:04:18
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\UserProjects;
use App\Repositories\ProjectsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;


/**
 * Class CategoryController
 * @package App\Http\Controllers\API
 */
class ProjectsAPIController extends Controller
{
    /** @var  ProjectsRepository */
    private $projectsRepository;

    public function __construct(ProjectsRepository $projectsRepo)
    {
        $this->projectsRepository = $projectsRepo;
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
            $this->projectsRepository->pushCriteria(new RequestCriteria($request));
            $this->projectsRepository->pushCriteria(new LimitOffsetCriteria($request));


        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        $projects = $this->projectsRepository->all();

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
        /** @var Projects $projects */
        if (!empty($this->projectsRepository)) {
            try {
                $this->projectsRepository->pushCriteria(new RequestCriteria($request));
                $this->projectsRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }

            $project = $this->projectsRepository->findWithoutFail($id);
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
            $project = $this->projectsRepository->create($input);

            $client_project = new UserProjects();
            $client_project->user_id = $input['user_id'];
            $client_project->project_id = $project->id;
            $client_project->save();


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
        $project = $this->projectsRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }
        $input = $request->all();
        try {
            $project = $this->projectsRepository->update($input, $id);

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
        $project = $this->projectsRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        $project = $this->projectsRepository->delete($id);

        return $this->sendResponse($project, __('lang.deleted_successfully'));
    }

}
