<?php
    include("db_connection.php");
    $userId=$_SESSION["account_id"];
    $processQuery="SELECT * FROM process WHERE `account_id`='$userId'";
    $result = mysqli_query($conn,$processQuery);
    $process_status=["in progress","finished","suspended","not started"];
    $labelDecoration=["btn-outline-green","btn-outline-primary","btn-outline-warning","btn-outline-secondary"];
    $labelColors="";
    $html="";
while ($process = mysqli_fetch_assoc($result)) {
    $html .= '
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card bg-dark-card text-white h-100 shadow">
        <div class="card-header justify-content-evenly">
          <h5 class="card-title mb-0">'.htmlspecialchars($process["process_number"]).'</h5>';
          for($i=0;$i<count($process_status);$i++)
          {
            if($process_status[$i]==$process['process_status'])
            {
                $labelColors=$labelDecoration[$i];
            }
          }
          $html.='<button class="btn p-1 w-auto '.htmlspecialchars($labelColors).'" disabled>'.$process["process_status"].'</button>
        </div>
        <div class="card-body">
          <h6 class="card-subtitle mb-2 text-warning">' . htmlspecialchars($process["title"]) . '</h6>
          <p class="card-text">' . htmlspecialchars($process["process_description"]) . '</p>
        </div>
        <div class="card-footer d-flex justify-content-between">
          <button class="btn btn-primary btn-sm edit-process" data-process-id="'.htmlspecialchars($process["process_id"]).'"><i class="bi bi-pencil-fill"></i> Editar</button>
          <button class="btn btn-danger btn-sm"><i class="bi bi-x-circle delete-process" data-process-id="'.htmlspecialchars($process["process_id"]).'"></i> Eliminar</button>
        </div>
      </div>
    </div>';
   }
    
?>
