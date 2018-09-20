/** Variable Common */
var objTaskCurrent = null;

/** Functions Common */
function callAjax(method, url, data, callbackSuccess)
{
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: function(result) {
            if (result['status'] == "success") {
                callbackSuccess(result['data'], data);
            } else {
                showNotify("error", "System error, please try again!");
            }
        },
        beforeSend: function(xhr) {
            disableOrEnableBtnAction("disable");
        },
        complete: function(xhr, status) {
            disableOrEnableBtnAction("enable");
        },
        error: function(xhr, status, error) {
            showNotify("error", "System error, please try again!");
        }
    });
}

function validateAndGetDataForm()
{
    hideErrorDataForm();

    var data = {};

    data['name'] = $("#form-name").val();
    data['start_date'] = $("#form-start-date").val();
    data['end_date'] = $("#form-end-date").val();
    data['status'] = $("#form-status").val();

    if (data['name'] == "") {
        showError("#form-name", "Please input the name of the task.");
        return false;
    }

    if (data['start_date'] == "") {
        showError("#form-start-date", "Please choose the start date of the task.");
        return false;
    }

    if (data['end_date'] == "") {
        showError("#form-end-date", "Please choose the end date of the task.");
        return false;
    } else if (data['end_date'] < data['start_date']) {
        showError("#form-end-date", "The end date must greater the start date.");
        return false;
    }

    return data;
}

function showError(element, message)
{
    $(element).addClass("is-invalid");
    showNotify("error", message);
}

function hideErrorDataForm()
{
    $(".form-group .form-control").removeClass("is-invalid");
}

function clearFormData()
{
    $("form")[0].reset();
}

function hideOrShowElement(element, action)
{
    if (action == "hide") {
        $(element).addClass("hide");
    } else {
        $(element).removeClass("hide");
    }
}

function showNotify(status, message)
{
    if (status == "success") {
        alert("Success: " +  message);
    } else {
        alert("Error: " + message);
    }
}

function getBackgroundStatus(status)
{
    switch(status) {
        case "1":
            return "#FFAA00"; break;
        case "2":
            return "#F6AE99"; break;
        default:
            return "#42B97C"; break;
    }
}

function disableOrEnableBtnAction(action)
{
    if (action == "disable") {
        $("button[type='submit']").attr("disabled");
    } else {
        $("button[type='submit']").prop("disabled", false);
    }
}

function formatDate(objDateTime)
{
    return moment(objDateTime).format("YYYY-MM-DD").toString();
}

function scrollToElement(element, time)
{
    $('html, body').animate({
        scrollTop: $(element).offset().top
    }, time);
}

/** Event: Load tasks on calendar */
function callbackLoadTaskSuccess(listTask)
{
    var tasks = [];
    
    listTask.forEach(function(task, index) {
        var taskOnCalendar = {
            id: task['id'],
            title: task['name'],
            start: task['start_date'],
            end: task['end_date'],
            status: task['status'],
            backgroundColor: getBackgroundStatus(task['status'])
        }
        tasks.push(taskOnCalendar);
    });
    
    $("#calendar").fullCalendar('removeEvents'); 
    $('#calendar').fullCalendar('addEventSource', tasks);
    $('#calendar').fullCalendar('rerenderEvents');
    
}

function loadTasksOnCalendar()
{
    var url = "/task"
    callAjax("GET", url, null, callbackLoadTaskSuccess);
}

/** Event click on task on the calendar */
function loadTaskToForm(event)
{
    hideErrorDataForm();
    var start_date = formatDate(event.start);
    var end_date = formatDate(event.end);
    $("#form-id").val(event.id);
    $("#form-name").val(event.title);
    $("#form-start-date").val(start_date);
    if (event.end != null) {
        $("#form-end-date").val(end_date);
    } else {
        $("#form-end-date").val(start_date);
    }
    $("#form-status").val(event.status);
    scrollToElement(".title-app", 500);
    hideOrShowElement("#btn-update-task", "show");
    hideOrShowElement("#btn-delete-task", "show");
    
    objTaskCurrent = event;
}

/** Event: Drag task on calendar */
function handleDragTaskOnCalendar(event)
{
    loadTaskToForm(event);
    updateTask();
}

/** Event: Click button create new task */
function callbackCreateTaskSuccess(dataResponse, infoTask)
{
    clearFormData();
    var taskOnCalendar = {
        id: dataResponse['id'],
        title: infoTask['name'],
        start: infoTask['start_date'],
        end: infoTask['end_date'],
        status: infoTask['status'],
        backgroundColor: getBackgroundStatus(infoTask['status'])
    }
    $('#calendar').fullCalendar('renderEvent', taskOnCalendar);
    hideOrShowElement("#btn-update-task", "hide");
    hideOrShowElement("#btn-delete-task", "hide");
    showNotify("success", "Create a new task is successful.");
}

function createTask()
{
    var dataForm = validateAndGetDataForm();
    
    if (!dataForm) {
        return false;
    }
    
    var url = "/task/create";
    callAjax("POST", url, dataForm, callbackCreateTaskSuccess);
}

$("#btn-add-task").on( "click", function() {
    createTask();
    return false;
});

/** Event: Click button to update task */
function callbackUpdateTaskSuccess(resultResponse, infoTask)
{
    objTaskCurrent.title = infoTask['name'];
    objTaskCurrent.start = infoTask['start_date'];
    objTaskCurrent.end = infoTask['end_date'];
    objTaskCurrent.backgroundColor = getBackgroundStatus(infoTask['status']);
    objTaskCurrent.status = infoTask['status'];

    $('#calendar').fullCalendar('updateEvent', objTaskCurrent);
    showNotify("success", "Update a task is successful.");
}

function updateTask()
{
    var dataForm = validateAndGetDataForm();
    var idTask = $("#form-id").val();
    
    if (!dataForm || idTask == "") {
        return false;
    }
    
    var url = "/task/update/" + idTask;
    callAjax("POST", url, dataForm, callbackUpdateTaskSuccess);
}

$("#btn-update-task").on( "click", function() {
    updateTask();
    return false;
});

/** Event: Click button delete task */
function callbackDeleteTaskSuccess()
{
    clearFormData();
    $('#calendar').fullCalendar('removeEvents', objTaskCurrent.id);
    hideOrShowElement("#btn-update-task", "hide");
    hideOrShowElement("#btn-delete-task", "hide");
    showNotify("success", "Delete a task is successful.");
}
function deleteTask()
{
    var idTask = $("#form-id").val();
    
    if (idTask == "") {
        return false;
    }
    
    var url = "/task/delete/" + idTask;
    callAjax("POST", url, [], callbackDeleteTaskSuccess);
}

$("#btn-delete-task").on( "click", function() {
    var objConfirm = confirm("Do you want to remove this task?");
    if (objConfirm == true) {
        deleteTask();
    }
    
    return false;
});

/** Run app */
$(function () {
    $('#form-start-date').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#form-end-date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        navLinks: true,
        editable: true,
        eventLimit: true,
        eventClick: function(calEvent, jsEvent, view) {
            loadTaskToForm(calEvent);
        },
        eventDrop: function(calEvent, jsEvent, view) {
            handleDragTaskOnCalendar(calEvent);
        },
    });

    loadTasksOnCalendar();
});
