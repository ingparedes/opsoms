<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Timeline = &$Page;
?>
<style>


.timeline{
  margin-top:20px;
  position:relative;
  
}

.timeline:before{
  position:absolute;
  content:'';
  width:4px;
  height:calc(100% + 50px);
background: rgb(251,251,251);
background: -moz-linear-gradient(left, rgba(138,145,150,1) 0%, rgba(122,130,136,1) 60%, rgba(98,105,109,1) 100%);
background: -webkit-linear-gradient(left, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(98,105,109,1) 100%);
background: linear-gradient(to right, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(98,105,109,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8a9196', endColorstr='#62696d',GradientType=1 );
  left:14px;
  top:5px;
  border-radius:4px;
}

.timeline-month{
  position:relative;
  padding:4px 15px 4px 35px;
  background-color:rgb(0, 123, 255);
  display:inline-block;
  width:auto;
  border-radius:40px;
  border-right-color:#fff;
  margin-bottom:30px;
}

.timeline-month span{
  position:absolute;
  top:-1px;
  left:calc(100% - 10px);
  z-index:-1;
  white-space:nowrap;
  display:inline-block;
  background-color:#111;
  padding:4px 10px 4px 20px;
  border-top-right-radius:40px;
  border-bottom-right-radius:40px;
  border:1px solid black;
  box-sizing:border-box;
}

.timeline-month:before{
  position:absolute;
  content:'';
  width:20px;
  height:20px;
background: rgb(252, 251, 251);
background: -moz-linear-gradient(top, rgba(138,145,150,1) 0%, rgba(122,130,136,1) 60%, rgba(112,120,125,1) 100%);
background: -webkit-linear-gradient(top, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(112,120,125,1) 100%);
background: linear-gradient(to bottom, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(112,120,125,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8a9196', endColorstr='#70787d',GradientType=0 );
  border-radius:100%;
  border:1px solid #17191B;
  left:5px;
}

.timeline-section{
  padding-left:35px;
  display:block;
  position:relative;
  margin-bottom:30px;
}

.timeline-date{
  margin-bottom:15px;
  padding:2px 15px;
  background:linear-gradient(#74cae3, #5bc0de 60%, #4ab9db);
  position:relative;
  display:inline-block;
  border-radius:20px;
  border:1px solid #17191B;
  color:#fff;
text-shadow:1px 1px 1px rgba(0,0,0,0.3);
}
.timeline-section:before{
  content:'';
  position:absolute;
  width:30px;
  height:1px;
  background-color:#444950;
  top:12px;
  left:20px;
}

.timeline-section:after{
  content:'';
  position:absolute;
  width:10px;
  height:10px;
  background:linear-gradient(to bottom, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(112,120,125,1) 100%);
  top:7px;
  left:11px;
  border:1px solid #17191B;
  border-radius:100%;
}

.timeline-section .col-sm-4{
  margin-bottom:15px;
}

.timeline-box{
  position:relative;
  
 background-color:#39f;
  border-radius:15px;
  border-top-left-radius:0px;
  border-bottom-right-radius:0px;
  border:1px solid #17191B;
  transition:all 0.3s ease;
  overflow:hidden;
}

.box-icon{
  position:absolute;
  right:5px;
  top:0px;
}

.box-title{
  padding:5px 15px;
  border-bottom: 1px solid #17191B;
}

.box-title i{
  margin-right:5px;
}

.box-content{
  padding:5px 15px;
  background-color:#ccc;
}

.box-content strong{
  color:#fff;
  font-style:italic;
  margin-right:5px;
}

.box-item{
  margin-bottom:5px;
}

.box-footer{
 padding:5px 15px;
  border-top: 1px solid #17191B;
  background-color:#fff;
  text-align:right;
  font-style:italic;
}


</style>

	</head>
	<body>
		<div class="container">
  <div class="timeline">
    <div class="timeline-month">
      Marzo 2021
      <span>3 Entries</span>
    </div>
    <div class="timeline-section">
      <div class="timeline-date">
       Día No.1 (2, Marzo)
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-asterisk text-success" aria-hidden="true"></i> Mensaje enviado
            </div>
            <div class="box-content">
              <a class="btn btn-xs btn-default pull-right">Detalle</a>
			  <div class="box-item"><strong>Tarea Relacionada</strong>: Entrega de mensaje 1</div>
              <div class="box-item"><strong>Mensaje</strong>: Mensaje 1: Terremoto en Costa Rica</div>
              <div class="box-item"><strong>De</strong>: Excon Grupo</div>
			  <div class="box-item"><strong>Para</strong>: Grupo USAR</div>
              <div class="box-item"><strong>Tiempo inicio real </strong>: 2021/03/02  13:00</div>
            </div>
            <div class="box-footer">- EXCON: David Paredes</div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-pencil text-info" aria-hidden="true"></i> Respuesta 
            </div>
            <div class="box-content">
              <a class="btn btn-xs btn-default pull-right"></a>
              <div class="box-item"><strong>Respuesta</strong>: Marlyn</div>
              <div class="box-item"><strong>Enviado</strong>: Grupo USAR</div>
            </div>
            <div class="box-footer">- EXCON: David Paredes </div>
          </div>
        </div>

      </div>

    </div>

    <div class="timeline-section">
      <div class="timeline-date">
        Día No.2 (3, Marzo)
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-pencil text-info" aria-hidden="true"></i> Job Edited
            </div>
            <div class="box-content">
              <a class="btn btn-xs btn-default pull-right">Detalle</a>
              <div class="box-item"></div>
              <div class="box-item"></div>
              <div class="box-item"></div>
              <div class="box-item"></div>
            </div>
            <div class="box-footer"></div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-tasks text-primary" aria-hidden="true"></i> Respuesta
            </div>
            <div class="box-content">
              <a class="btn btn-xs btn-default pull-right">Details</a>
              <div class="box-item"><strong>Employee</strong>: Sam</div>
              <div class="box-item"><strong>To Do</strong>: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nisi nulla, viverra quis felis sit amet, lacinia feugiat odio. Aliquam sed orci elementum, volutpat dolor eget, venenatis nunc</div>
            </div>
            <div class="box-footer">- Marlyn</div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-tasks text-primary" aria-hidden="true"></i> Respuesta
            </div>
            <div class="box-content">
              <a class="btn btn-xs btn-default pull-right">Details</a>
              <div class="box-item"><strong>Employee</strong>: Jones</div>
              <div class="box-item"><strong>To Do</strong>: Proin sit amet aliquet neque, eget sagittis nunc. Proin convallis lectus quis volutpat pharetra. Donec quis ultrices eros. Ut eget mi faucibus.</div>
            </div>
            <div class="box-footer">- Marlyn</div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-thermometer-half text-warning" aria-hidden="true"></i> Pschrometrics
            </div>
            <div class="box-content">
              <div class="box-item"><strong>Temp.</strong>: 23 <sup>o</sup>C</div>
              <div class="box-item"><strong>Rh </strong>: 42</div>
              <div class="box-item"><strong>Comments</strong>: Integer nec placerat ipsum. Aliquam id ligula suscipit, ornare dui nec, laoreet tortor.</div>
            </div>
            <div class="box-footer">- Jones</div>
          </div>
        </div>
        
                <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-building-o text-default" aria-hidden="true"></i> Room Created
            </div>
            <div class="box-content">
              <div class="box-item"><strong>Name</strong>: Kitchen</div>
              <div class="box-item"><strong>Floor Level </strong>: 2</div>
              <div class="box-item"><strong>Dimensions</strong>: 26 x 11 x 8</div>
            </div>
            <div class="box-footer">- Sam</div>
          </div>
        </div>
        
      </div>

    </div>
    
    <div class="timeline-section">
      <div class="timeline-date">
        23, Thursday
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-tasks text-success" aria-hidden="true"></i> Respuesta
            </div>
            <div class="box-content">
              <a class="btn btn-xs btn-default pull-right">Details</a>
              <div class="box-item"><strong>Employee</strong>: Sam</div>
              <div class="box-item"><strong>Employee Response</strong>: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nisi nulla, viverra quis felis sit amet, lacinia feugiat odio. Aliquam sed orci elementum, volutpat dolor eget, venenatis nunc</div>
            </div>
            <div class="box-footer">- Carol</div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="timeline-box">
            <div class="box-title">
              <i class="fa fa-cogs text-info" aria-hidden="true"></i> Equipment Entry
            </div>
            <div class="box-content">
              <a class="btn btn-xs btn-default pull-right">Details</a>
              <div class="box-item"><strong>ID</strong>: TW-3232</div>
              <div class="box-item"><strong>Name</strong>: HEPA 600</div>
                            <div class="box-item"><strong>Date In</strong>: 08/22/2018</div>
            </div>
            <div class="box-footer">- Jones</div>
          </div>
        </div>

      </div>

    </div>

  </div>
</div>

<?= GetDebugMessage() ?>
