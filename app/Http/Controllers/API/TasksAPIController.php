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
use App\Models\Project_tasks;
use App\Models\Projects;
use App\Models\Tasks;
use App\Models\UserProjects;
use App\Repositories\ProjectsRepository;
use App\Repositories\TasksRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;


/**
 * Class CategoryController
 * @package App\Http\Controllers\API
 */
class TasksAPIController extends Controller
{
    /** @var  TasksRepository */
    private $tasksRepository;

    public function __construct(TasksRepository $tasksRepo)
    {
        $this->tasksRepository = $tasksRepo;
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
            $this->tasksRepository->pushCriteria(new RequestCriteria($request));
            $this->tasksRepository->pushCriteria(new LimitOffsetCriteria($request));


        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        $tasks = $this->tasksRepository->all();

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

        return $this->sendResponse($tasks, 'Tasks retrieved successfully');
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
        /** @var Tasks $task */
        if (!empty($this->tasksRepository)) {
            try {
                $this->tasksRepository->pushCriteria(new RequestCriteria($request));
                $this->tasksRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }

            $task = $this->tasksRepository->findWithoutFail($id);
        }
        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        return $this->sendResponse($task->toArray(), 'Task retrieved successfully');
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
            $task = $this->tasksRepository->create([
                'title' => $input['title'],
                'status' => $input['status'],
            ]);

            $client_project = new Project_tasks();
            $client_project->project_id = $input['project_id'] ?? null;
            $client_project->tasks_id = $task->id;
            $client_project->save();


        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($task->toArray(), __('lang.saved_successfully'));
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
        $task = $this->tasksRepository->findWithoutFail($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }
        $input = $request->all();
        try {
            $task = $this->tasksRepository->update($input, $id);

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($task->toArray(), __('lang.updated_successfully'));

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
        $task = $this->tasksRepository->findWithoutFail($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task = $this->tasksRepository->delete($id);

        return $this->sendResponse($task, __('lang.deleted_successfully'));
    }

}
