<?php

use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Task;

// Ana sayfadan tasks.index rotasına yönlendirme
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Tüm tamamlanmış görevleri listeleme
Route::get('/tasks', function () {
    return view('index', [
         'tasks' => Task::latest()->paginate(10)
         //->where('completed', true)
    ]);
})->name('tasks.index');

// Görev oluşturma sayfası
Route::view('/tasks/create', 'create')->name('tasks.create');


Route::get('/tasks/{task}/edit', function (Task $task) {
  return view('edit', ['task' => $task
  //id göndermezsen böyle gönderirsen findorfaile ihtiyacın yok auto fetch eder dbden
  //you have to be model Task
  //hepsini döndermek istediğimizde değilde 1 tane döndermek istediğimizde böyle yap.
]);
})->name('tasks.edit');



// Belirli bir görevi görüntüleme
Route::get('/tasks/{task}', function (Task $task) {
    return view('show', ['task' => $task]);
})->name('tasks.show');

Route::post("/tasks",function(TaskRequest $request){
//    $data=$request->validated();
//    $task=new Task;
//    $task->title=$data["title"];
//    $task->description=$data["description"];
//    $task->long_description=$data["long_description"];
//    $task->save();
   $task=Task::create($request->validated());
   //dbye kaydeder 
   return redirect()->route("tasks.show",["task"=>$task->id])
   //tırnak içine yazılmış id veritabanındaki id'dir
   //dbye kaydettiğimiz seye gider.
   ->with("success","Task Created Successfully!");
  })->name("tasks.store");

   Route::put("/tasks/{task}",function(Task $task,TaskRequest $request){
    //$data=$request->validated();
    // $task->title=$data["title"];
    // $task->description=$data["description"];
    // $task->long_description=$data["long_description"];
    // $task->save();
     $task->update($request->validated());

    //dbye kaydeder 
    return redirect()->route("tasks.show",["task"=>$task->id])
    //tırnak içine yazılmış id veritabanındaki id'dir
    //dbye kaydettiğimiz seye gider.
    ->with("success","Task Updated Successfully!"); 
})->name("tasks.update");

    Route::delete("/tasks/{task}",function(Task $task){
        $task->delete();
        return redirect()->route("tasks.index")
        ->with("success","Task deleted successfully");
    })->name("tasks.destroy");


    Route::put("/tasks/{task}/toggle-complete",function(Task $task){
        $task->toggleComplete();

        return redirect()->back()->with("success","Task Updated Successfully!");
        //back bi önceki sayfaya döndürür
    })->name("tasks.toggle-complete");

// Basit bir selamlama mesajı döndüren rota
Route::get('/hello', function () {
    return 'Hello';
});

// /hallo yolu /hello yoluna yönlendirilir
Route::get('/hallo', function () {
    return redirect('/hello');
});

// Mevcut olmayan yollara yönlendirmek için fallback rota
Route::fallback(function () {
    return 'Nothing here. Check the URL or try something else.';
});