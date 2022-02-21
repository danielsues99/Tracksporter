<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tablas mensuales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>

</body>
</html>

<?php
$year=$_REQUEST['year'];
$mes=$_REQUEST['month'];
// Creamos el arreglo con los meses y fechas correspondientes
    $month[1] = array("01-01", "02-01"); $month[2] = array("02-01", "03-01");
    $month[3] = array("03-01", "04-01"); $month[4] = array("04-01", "05-01");
    $month[5] = array("05-01", "06-01"); $month[6] = array("06-01", "07-01");
    $month[7] = array("07-01", "08-01"); $month[8] = array("08-01", "09-01");
    $month[9] = array("09-01", "10-01"); $month[10] = array("10-01", "11-01");
    $month[11] = array("11-01", "12-01"); $month[12] = array("12-01", "01-01");

for ($i=1; $i < 12; $i++) { 
    if ($mes == $i){
        $diainicio = "$year-".$month[$i][0];
        $diafin = "$year-".$month[$i][1];
    }   
}
// Creamos if especifico para diciembre al cambiar fecha fin
if ($mes == 12){
    $yearEnd = $year+1;
    $diainicio = "$year-".$month[12][0];
    $diafin = "$yearEnd-".$month[12][1];
}

// Damos formato de fecha
$fecha=$mes.'_'.$year;
// Abrimos el archivo //
$documento=fopen('TablasMensuales.sql', 'w') or die('Error al crear archivo');

// Iniciamos la escritura de la info
fwrite($documento, "\n-- MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
-- MMMMMMMMM    SCRIPTS DE EJECUCION MENSUAL    MMMMMMMMM
-- MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM

-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ESQUEMA ESTADISTICAS

-- FRECUENCIA DE LA TABLA: Mensual <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS estadisticas.estadisticas_conductor_$fecha;
CREATE TABLE estadisticas.estadisticas_conductor_$fecha (
    CONSTRAINT pk_estadisticas_conductor_$fecha PRIMARY KEY (id),
    CONSTRAINT estadisticas_vehiculo_$fecha"."_fecha_check CHECK (fecha >= '$diainicio'::date AND fecha < '$diafin'::date)
)
INHERITS (estadisticas.estadisticas_conductor_1) TABLESPACE pg_default;

ALTER TABLE estadisticas.estadisticas_conductor_$fecha OWNER to postgres;
GRANT ALL ON TABLE estadisticas.estadisticas_conductor_$fecha TO \"adminTLC\";
GRANT SELECT ON TABLE estadisticas.estadisticas_conductor_$fecha TO consultor;
GRANT ALL ON TABLE estadisticas.estadisticas_conductor_$fecha TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE estadisticas.estadisticas_conductor_$fecha TO web;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Mensual <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS estadisticas.estadisticas_punto_interes_$fecha;
CREATE TABLE estadisticas.estadisticas_punto_interes_$fecha
(
    CONSTRAINT primary_key_estadistica_punto_interes_$fecha PRIMARY KEY (id),
    CONSTRAINT foreign_key_punto_estadistica_punto_interes_$fecha FOREIGN KEY (punto_interes)
        REFERENCES controles.puntointeres (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT foreign_key_vehiculo_estadistica_punto_interes_$fecha FOREIGN KEY (vehiculo)
        REFERENCES public.vehiculo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT estadisticas_punto_interes_$fecha"."_fecha_check CHECK (fecha >= '$diainicio'::date AND fecha < '$diafin'::date)
)
INHERITS (estadisticas.estadisticas_punto_interes_1) TABLESPACE pg_default;

ALTER TABLE estadisticas.estadisticas_punto_interes_$fecha OWNER to postgres;
GRANT ALL ON TABLE estadisticas.estadisticas_punto_interes_$fecha TO \"adminTLC\";
GRANT SELECT ON TABLE estadisticas.estadisticas_punto_interes_$fecha TO consultor;
GRANT ALL ON TABLE estadisticas.estadisticas_punto_interes_$fecha TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE estadisticas.estadisticas_punto_interes_$fecha TO web;

DROP INDEX IF EXISTS estadisticas.fecha_date_punto_interes_estadistica_$fecha;
CREATE INDEX fecha_date_punto_interes_estadistica_$fecha
    ON estadisticas.estadisticas_punto_interes_$fecha USING btree
    (fecha ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
-- FRECUENCIA DE LA TABLA: Mensual <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS estadisticas.estadisticas_ruta_$fecha;
CREATE TABLE estadisticas.estadisticas_ruta_$fecha
(
    CONSTRAINT pk_estadisticas_ruta_$fecha PRIMARY KEY (id),
    CONSTRAINT estadisticas_vehiculo_$fecha"."_fecha_check CHECK (fecha >= '$diainicio'::date AND fecha < '$diafin'::date)
)
INHERITS (estadisticas.estadisticas_ruta_1) TABLESPACE pg_default;

ALTER TABLE estadisticas.estadisticas_ruta_$fecha OWNER to postgres;
GRANT ALL ON TABLE estadisticas.estadisticas_ruta_$fecha TO \"adminTLC\";
GRANT SELECT ON TABLE estadisticas.estadisticas_ruta_$fecha TO consultor;
GRANT INSERT, SELECT, UPDATE, DELETE ON TABLE estadisticas.estadisticas_ruta_$fecha TO finandina;
GRANT ALL ON TABLE estadisticas.estadisticas_ruta_$fecha TO postgres;
GRANT INSERT, SELECT, UPDATE, DELETE ON TABLE estadisticas.estadisticas_ruta_$fecha TO web;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Mensual <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS estadisticas.estadisticas_vehiculo_$fecha;
CREATE TABLE estadisticas.estadisticas_vehiculo_$fecha
(
    CONSTRAINT pk_estadisticas_vehiculo_$fecha PRIMARY KEY (id),
    CONSTRAINT estadisticas_vehiculo_$fecha"."_identificador_fkey FOREIGN KEY (identificador)
        REFERENCES public.vehiculo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT estadisticas_vehiculo_$fecha"."_fecha_check CHECK (fecha >= '$diainicio'::date AND fecha < '$diafin'::date)
) INHERITS (estadisticas.estadisticas_vehiculo_1) TABLESPACE pg_default;

ALTER TABLE estadisticas.estadisticas_vehiculo_$fecha OWNER to postgres;
GRANT ALL ON TABLE estadisticas.estadisticas_vehiculo_$fecha TO \"adminTLC\";
GRANT SELECT ON TABLE estadisticas.estadisticas_vehiculo_$fecha TO consultor;
GRANT ALL ON TABLE estadisticas.estadisticas_vehiculo_$fecha TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE estadisticas.estadisticas_vehiculo_$fecha TO web;

DROP INDEX IF EXISTS estadisticas.estadisticas_vehiculo_fecha_$fecha;
CREATE INDEX estadisticas_vehiculo_fecha_$fecha
    ON estadisticas.estadisticas_vehiculo_$fecha USING btree
    (fecha ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS estadisticas.estadisticas_vehiculo_id_$fecha;
CREATE INDEX estadisticas_vehiculo_id_$fecha
    ON estadisticas.estadisticas_vehiculo_$fecha USING btree
    (identificador ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Mensual <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS estadisticas.his_desplazamiento_$fecha;
CREATE TABLE estadisticas.his_desplazamiento_$fecha
(
    CONSTRAINT his_desplazamiento_$fecha"."_pkey PRIMARY KEY (id),
    CONSTRAINT fk_estadisticashis_desplazamiento_$fecha"."_vehiculo FOREIGN KEY (vehiculo)
        REFERENCES public.vehiculo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT estadisticashis_desplazamiento_$fecha"."_check CHECK (fecha >= '$diainicio'::date AND fecha < '$diafin'::date)
) INHERITS (estadisticas.his_desplazamiento_1) TABLESPACE pg_default;

ALTER TABLE estadisticas.his_desplazamiento_$fecha OWNER to postgres;
GRANT ALL ON TABLE estadisticas.his_desplazamiento_$fecha TO \"adminTLC\";
GRANT SELECT ON TABLE estadisticas.his_desplazamiento_$fecha TO consultor;
GRANT ALL ON TABLE estadisticas.his_desplazamiento_$fecha TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE estadisticas.his_desplazamiento_$fecha TO web;

DROP INDEX IF EXISTS estadisticas.index_estadisticashis_desplazamiento_$fecha;

CREATE INDEX index_estadisticashis_desplazamiento_$fecha
    ON estadisticas.his_desplazamiento_$fecha USING btree
    (vehiculo ASC NULLS LAST, fecha ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Mensual <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS estadisticas.his_paradas_$fecha;
CREATE TABLE estadisticas.his_paradas_$fecha
(
    CONSTRAINT his_paradas_$fecha"."_pkey PRIMARY KEY (id),
    CONSTRAINT fk_estadisticashis_paradas_$fecha"."_vehiculo FOREIGN KEY (vehiculo)
        REFERENCES public.vehiculo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT estadisticashis_paradas_$fecha"."_check CHECK (fecha >= '$diainicio'::date AND fecha < '$diafin'::date)
) INHERITS (estadisticas.his_paradas_1) TABLESPACE pg_default;

ALTER TABLE estadisticas.his_paradas_$fecha
    OWNER to postgres;

GRANT ALL ON TABLE estadisticas.his_paradas_$fecha TO \"adminTLC\";
GRANT SELECT ON TABLE estadisticas.his_paradas_$fecha TO consultor;
GRANT ALL ON TABLE estadisticas.his_paradas_$fecha TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE estadisticas.his_paradas_$fecha TO web;

DROP INDEX IF EXISTS estadisticas.index_estadisticashis_paradas_$fecha;

CREATE INDEX index_estadisticashis_paradas_$fecha
    ON estadisticas.his_paradas_$fecha USING btree
    (vehiculo ASC NULLS LAST, fecha ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&\n");
fclose($documento); //Cerramos el documento

// Js para copiar texto
PRINT <<<HERE
<script>
    function ejecutar(idelemento){
  var aux = document.createElement("div");
  aux.setAttribute("contentEditable", true);
  aux.innerHTML = document.getElementById(idelemento).innerHTML;
  aux.setAttribute("onfocus", "document.execCommand('selectAll',false,null)"); 
  document.body.appendChild(aux);
  aux.focus();
  document.execCommand("copy");
  document.body.removeChild(aux);
  alert("Copiado al portapapeles!");
}
</script>
<div class="alert alert-success" role="alert">
    <center>Script generado correctamente  !</center>
</div>
<div>
    <center><a class="btn btn-warning" href="mensual.html" role="button" align="right">Volver<br></a></center>
</div><br>
<div>
    <center><button onclick="ejecutar('textarea')" class="btn btn-info">Copiar<br></button><br></center>
</div>
HERE;
$file = file_get_contents('TablasMensuales.sql');
    echo "<div class='form-floating'><pre class='form-control' id='textarea' style='height: 600px' class='with-space:pre-line'>\n";
    echo htmlspecialchars($file)."\n";
    echo "</pre></div>";
header("refresh:5;url=mensual.html");
exit;
?>