<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Inicio = &$Page;
?>
<section class="content">
      <div class="container-fluid">
        <!-- grupo -->
        <div class="card card-default">
          <div class="card-header">
             <h3 class="card-title"> <i class="cil-people"></i>  Grupos</h3>

              <div class="card-tools">

<button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
              </div>
            </div>
            <div >
             <object data="GrupoList?cmd=resetall" class="embed-responsive-item" width="100%" height="320px" ></object>


            </div>

        </div>

        

        <!-- subgrupo -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"> <i class="cil-contact"></i>  Subgrupo</h3>

            <div class="card-tools">

             <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
            </div>
         <div>

    
             <object data="SubgrupoList?cmd=resetall" width="100%" height="320px" style = "overflow:hidden; border:1px" onload="rezise(this);"></object>

          </div>

        </div>




        <!-- Tareas -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">  <i class="cil-laptop"></i>   Tareas</h3>

            <div class="card-tools">

             <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
            </div>
          <div>
    
        
<object data="TareasList?cmd=resetall" width="100%" height="400px" style = "overflow:hidden; border:1px" onload="rezise(this);"></object>

          </div>

        </div>

      </div>
</section>

<?= GetDebugMessage() ?>
