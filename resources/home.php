<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>APP TODO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    
    <link rel="stylesheet" href="/assets/css/fullcalendar.min.css" />

    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/main.css" />
</head>
<body>
    
<div id="app">
    <div>
        <div class="title-app">
            <h1>APP TODO</h1>
            <span>Type task text, date start, date end and status. Click on card to move to another date on calendar.</span>
        </div>
        
        <div class="form-container form-inline">
            <form method="POST">
                <input name="id" value="" id="form-id" type="hidden" />

                <div class="form-group">
                    <input type="text" id="form-name" class="form-control" name="name" placeholder="New Task...">
                </div>
                <div class="form-group ">
                    <input type="text" id="form-start-date" class="form-control" name="start_date" placeholder="Start date...">
                </div>
                <div class="form-group ">
                    <input type="text" id="form-end-date" class="form-control" name="end_date" placeholder="End date...">
                </div>
                <div class="form-group ">
                    <select id="form-status" class="form-control" name="status">
                        <option value="0">PLAINNING</option>
                        <option value="1">DOING</option>
                        <option value="2">COMPLETE</option>
                    </select>
                </div>
                
                <button id="btn-add-task" type="submit" class="btn btn-primary ">ADD</button>
                <button id="btn-update-task" type="submit" class="btn btn-info hide">UPDATE</button>
                <button id="btn-delete-task" type="submit" class="btn btn-danger hide">DELETE</button>
            </form>
        </div>
        
        <div id='calendar'></div>
        
    </div>
</div>

<script src="/assets/js/jquery.min.js"></script>

<script src="/assets/js/bootstrap.min.js"></script>

<script src="/assets/js/moment.min.js"></script>

<script src="/assets/js/bootstrap-datetimepicker.min.js"></script>

<script src="/assets/js/fullcalendar.min.js"></script>

<script src="/assets/js/main.js"></script>

</body>
</html>