<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tablas semanales Tracksporte - Datatraffic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>

</body>
</html>

<?php
$year=$_REQUEST['year'];
$week=$_REQUEST['week'];
///// Definiendo el arreglo/////
                $semana[1] = array("01-01", "01-08"); $semana[2] = array("01-08", "01-15");
                $semana[3] = array("01-15", "01-22"); $semana[4] = array("01-22", "01-29");
                $semana[5] = array("01-29", "02-05"); $semana[6] = array("02-05", "02-12");
                $semana[7] = array("02-12", "02-19"); $semana[8] = array("02-19", "02-26");
                $semana[9] = array("02-26", "03-05"); $semana[10] = array("03-05", "03-12");
                $semana[11] = array("03-12", "03-19"); $semana[12] = array("03-19", "03-26");
                $semana[13] = array("03-26", "04-02"); $semana[14] = array("04-02", "04-09");
                $semana[15] = array("04-09", "04-16"); $semana[16] = array("04-16", "04-23");
                $semana[17] = array("04-23", "04-30"); $semana[18] = array("04-30", "05-07");
                $semana[19] = array("05-07", "05-14"); $semana[20] = array("05-14", "05-21");
                $semana[21] = array("05-21", "05-28"); $semana[22] = array("05-28", "06-04");
                $semana[23] = array("06-04", "06-11"); $semana[24] = array("06-11", "06-18");
                $semana[25] = array("06-18", "06-25"); $semana[26] = array("06-25", "07-02");
                $semana[27] = array("07-02", "07-09"); $semana[28] = array("07-09", "07-16");
                $semana[29] = array("07-16", "07-23"); $semana[30] = array("07-23", "07-30");
                $semana[31] = array("07-30", "08-06"); $semana[32] = array("08-06", "08-13");
                $semana[33] = array("08-13", "08-20"); $semana[34] = array("08-20", "08-27");
                $semana[35] = array("08-27", "09-03"); $semana[36] = array("09-03", "09-10");
                $semana[37] = array("09-10", "09-17"); $semana[38] = array("09-17", "09-24");
                $semana[39] = array("09-24", "10-01"); $semana[40] = array("10-01", "10-08");
                $semana[41] = array("10-08", "10-15"); $semana[42] = array("10-15", "10-22");
                $semana[43] = array("10-22", "10-29"); $semana[44] = array("10-29", "11-05");
                $semana[45] = array("11-05", "11-12"); $semana[46] = array("11-12", "11-19");
                $semana[47] = array("11-19", "11-26"); $semana[48] = array("11-26", "12-03");
                $semana[49] = array("12-03", "12-10"); $semana[50] = array("12-10", "12-17");
                $semana[51] = array("12-17", "12-24"); $semana[52] = array("12-24", "12-31");
                $semana[53] = array("12-31", "01-07");

for ($i=1; $i < 53; $i++) { 
    if ($week == $i){
        $diainicio = "$year-".$semana[$i][0];
        $diafin = "$year-".$semana[$i][1];
    }   
}
// Creamos if especifico para semana 53 al cambiar fecha fin
if ($week == 53){
    $yearEnd = $year+1;
    $diainicio = "$year-".$semana[53][0];
    $diafin = "$yearEnd-".$semana[53][1];
} 
/// Creamos documento ///
$archivo=fopen('TablasSemanales.sql', 'w') or die('Error al crear archivo');
/// Capturamos info del usuario ///
$semana=$week.'_'.$year;

fwrite($archivo, "
-- SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
-- SSSSSSSSS    SCRIPTS DE EJECUCION SEMANAL    SSSSSSSSS
-- SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS

-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ESQUEMA PARSEO

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS parseo.trama_$semana;
CREATE TABLE parseo.trama_$semana
(
    CONSTRAINT pk_trama_$semana PRIMARY KEY (id),
    CONSTRAINT trama_$semana"."_fecha_check CHECK (fecha >= '$diainicio 00:00:00'::timestamp without time zone AND fecha < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (parseo.trama_1) TABLESPACE pg_default;

ALTER TABLE parseo.trama_$semana OWNER to postgres;
GRANT ALL ON TABLE parseo.trama_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE parseo.trama_$semana TO consultor;
GRANT ALL ON TABLE parseo.trama_$semana TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE parseo.trama_$semana TO web;

-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ESQUEMA SEGUIMIENTO

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.calculo_carga_$semana;
CREATE TABLE seguimiento_datos.calculo_carga_$semana
(
    CONSTRAINT pk_calculo_carga_$semana PRIMARY KEY (id),
    CONSTRAINT calculo_carga_$semana"."_updatetime_check CHECK (updatetime >= '$diainicio 00:00:00'::timestamp without time zone AND updatetime < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.calculo_carga) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.calculo_carga_$semana OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.calculo_carga_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE seguimiento_datos.calculo_carga_$semana TO consultor;
GRANT ALL ON TABLE seguimiento_datos.calculo_carga_$semana TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.calculo_carga_$semana TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.calculo_carga_$semana TO web;

DROP INDEX IF EXISTS seguimiento_datos.ind_vh_up_calculo_carga_$semana;
CREATE INDEX ind_vh_up_calculo_carga_$semana
    ON seguimiento_datos.calculo_carga_$semana USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST, skiped ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.calculos_combustible_$semana;
CREATE TABLE seguimiento_datos.calculos_combustible_$semana
(
    CONSTRAINT pk_calculos_combustible_$semana PRIMARY KEY (id),
    CONSTRAINT fk_estado_combustible_$semana FOREIGN KEY (estado_combustible)
        REFERENCES public.estado_tipo_variable (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE RESTRICT,
    CONSTRAINT fk_vehiculo_combustible_$semana FOREIGN KEY (vehiculo)
        REFERENCES public.vehiculo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE RESTRICT,
    CONSTRAINT calculos_combustible_$semana"."_updatetime_check CHECK (updatetime >= '$diainicio 00:00:00'::timestamp without time zone AND updatetime < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.calculos_combustible) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.calculos_combustible_$semana OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.calculos_combustible_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE seguimiento_datos.calculos_combustible_$semana TO consultor;
GRANT ALL ON TABLE seguimiento_datos.calculos_combustible_$semana TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.calculos_combustible_$semana TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.calculos_combustible_$semana TO web;

DROP INDEX IF EXISTS seguimiento_datos.calculo_cmb_posicion_$semana;
CREATE INDEX calculo_cmb_posicion_$semana
    ON seguimiento_datos.calculos_combustible_$semana USING btree
    (posicion ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.fki_estado_$semana;
CREATE INDEX fki_estado_$semana
    ON seguimiento_datos.calculos_combustible_$semana USING btree
    (estado_combustible ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.ind_sk_st_$semana;
CREATE INDEX ind_sk_st_$semana
    ON seguimiento_datos.calculos_combustible_$semana USING btree
    (estado_combustible ASC NULLS LAST, skiped ASC NULLS LAST, vehiculo ASC NULLS LAST)
    TABLESPACE pg_default
    WHERE estado_combustible <> 8 AND skiped = false;

DROP INDEX IF EXISTS seguimiento_datos.ind_vh_up_sk_$semana;
CREATE INDEX ind_vh_up_sk_$semana
    ON seguimiento_datos.calculos_combustible_$semana USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST, skiped ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_evento_$semana;
CREATE TABLE seguimiento_datos.historial_evento_$semana
(
    CONSTRAINT pk_historial_evento_$semana PRIMARY KEY (id),
    CONSTRAINT historial_evento_$semana"."_updatetime_check CHECK (updatetime >= '$diainicio 00:00:00'::timestamp without time zone AND updatetime < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_evento_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_evento_$semana OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_evento_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE seguimiento_datos.historial_evento_$semana TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_evento_$semana TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_evento_$semana TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_evento_$semana TO web;

DROP INDEX IF EXISTS seguimiento_datos.idx_pos_historial_evento_$semana;
CREATE INDEX idx_pos_historial_evento_$semana
    ON seguimiento_datos.historial_evento_$semana USING btree
    (posicion ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.idx_vh_up_tv_historial_evento_$semana;
CREATE INDEX idx_vh_up_tv_historial_evento_$semana
    ON seguimiento_datos.historial_evento_$semana USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST, tipo_evento ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_extra_$semana;
CREATE TABLE seguimiento_datos.historial_extra_$semana
(
    CONSTRAINT pk_historial_extra_$semana PRIMARY KEY (id),
    CONSTRAINT historial_extra_$semana"."_updatetime_check CHECK (updatetime >= '$diainicio 00:00:00'::timestamp without time zone AND updatetime < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_extra_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_extra_$semana OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_extra_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE seguimiento_datos.historial_extra_$semana TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_extra_$semana TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_extra_$semana TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_extra_$semana TO web;

DROP INDEX IF EXISTS seguimiento_datos.idx_pos_tv_historial_extra_$semana;
CREATE INDEX idx_pos_tv_historial_extra_$semana
    ON seguimiento_datos.historial_extra_$semana USING btree
    (posicion ASC NULLS LAST, tipo_variable ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.idx_vh_up_tv_historial_extra_$semana;
CREATE INDEX idx_vh_up_tv_historial_extra_$semana
    ON seguimiento_datos.historial_extra_$semana USING btree
    (vehiculo ASC NULLS LAST, tipo_variable ASC NULLS LAST, updatetime ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_novedades_viaje_$semana;

CREATE TABLE seguimiento_datos.historial_novedades_viaje_$semana
(
    CONSTRAINT pk_historial_novedades_viaje_$semana PRIMARY KEY (id),
    CONSTRAINT historial_novedades_viaje_$semana"."_fecha_check CHECK (fecha >= '$diainicio 00:00:00'::timestamp without time zone AND fecha < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_novedades_viaje_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_novedades_viaje_$semana OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_novedades_viaje_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE seguimiento_datos.historial_novedades_viaje_$semana TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_novedades_viaje_$semana TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_novedades_viaje_$semana TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_novedades_viaje_$semana TO web;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_posicion_$semana;
CREATE TABLE seguimiento_datos.historial_posicion_$semana
(
    CONSTRAINT pk_historial_posicion_$semana PRIMARY KEY (id),
    CONSTRAINT historial_posicion_$semana"."_updatetime_check CHECK (updatetime >= '$diainicio 00:00:00'::timestamp without time zone AND updatetime < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_posicion_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_posicion_$semana OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_posicion_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE seguimiento_datos.historial_posicion_$semana TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_posicion_$semana TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_posicion_$semana TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_posicion_$semana TO web;

DROP INDEX IF EXISTS seguimiento_datos.idx_historial_posicion__$semana"."_uptm;
CREATE INDEX idx_historial_posicion__$semana"."_uptm
    ON seguimiento_datos.historial_posicion_$semana USING btree
    (updatetime DESC NULLS FIRST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.idx_historial_posicion__$semana"."_vh_uptm;
CREATE INDEX idx_historial_posicion__$semana"."_vh_uptm
    ON seguimiento_datos.historial_posicion_$semana USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_viaje_$semana;
CREATE TABLE seguimiento_datos.historial_viaje_$semana
(
    CONSTRAINT pk_historial_viaje_$semana PRIMARY KEY (id),
    CONSTRAINT historial_viaje_$semana"."_updatetime_check CHECK (fecha_creacion >= '$diainicio 00:00:00'::timestamp without time zone AND fecha_creacion < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_viaje_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_viaje_$semana OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_viaje_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE seguimiento_datos.historial_viaje_$semana TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_viaje_$semana TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_viaje_$semana TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_viaje_$semana TO web;

DROP INDEX IF EXISTS seguimiento_datos.index_historial_viaje_$semana;
CREATE INDEX index_historial_viaje_$semana
    ON seguimiento_datos.historial_viaje_$semana USING btree
    (vehiculo ASC NULLS LAST, ruta ASC NULLS LAST, viaje ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ESQUEMA CONSOLIDADOS

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS consolidados.historial_consolidado_$semana;
CREATE TABLE consolidados.historial_consolidado_$semana
(
    CONSTRAINT pk_historial_consolidado_$semana PRIMARY KEY (id),
    CONSTRAINT fk_cnd_historial_consolidado_$semana FOREIGN KEY (conductor)
        REFERENCES conductores.conductor (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE RESTRICT,
    CONSTRAINT fk_vehiculo_historial_consolidado_$semana FOREIGN KEY (vehiculo)
        REFERENCES public.vehiculo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE RESTRICT,
    CONSTRAINT historial_consolidado_$semana"."_updatetime_check CHECK (updatetime >= '$diainicio 00:00:00'::timestamp without time zone AND updatetime < '$diafin 00:00:00'::timestamp without time zone)
) INHERITS (consolidados.historial_consolidado_1) TABLESPACE pg_default;

ALTER TABLE consolidados.historial_consolidado_$semana OWNER to postgres;
GRANT ALL ON TABLE consolidados.historial_consolidado_$semana TO \"adminTLC\";
GRANT SELECT ON TABLE consolidados.historial_consolidado_$semana TO consultor;
GRANT ALL ON TABLE consolidados.historial_consolidado_$semana TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE consolidados.historial_consolidado_$semana TO web;

DROP INDEX IF EXISTS consolidados.idx_fch_vh_historial_consolidado_$semana;
CREATE INDEX idx_fch_vh_historial_consolidado_$semana
    ON consolidados.historial_consolidado_$semana USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST, visible ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&");

fclose($archivo); //Cerramos el archivo
// -- Creamos visualización de script en Web -- //
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
    <center><a class="btn btn-warning" href="semanal.html" role="button" align="right">Volver<br></a></center>
</div><br>
<div>
    <center><button onclick="ejecutar('textarea')" class="btn btn-info">Copiar<br></button><br></center>
</div>
HERE;
$file = file_get_contents('TablasSemanales.sql');
    echo "<div class='form-floating'><pre class='form-control' id='textarea' style='height: 600px' class='with-space:pre-line'>\n";
    echo htmlspecialchars($file)."\n";
    echo "</pre></div>";

header("refresh:5;url=index.html");
exit;
?>