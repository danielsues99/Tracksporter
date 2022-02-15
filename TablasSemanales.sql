
-- SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
-- SSSSSSSSS    SCRIPTS DE EJECUCION SEMANAL    SSSSSSSSS
-- SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS

-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ESQUEMA PARSEO

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS parseo.trama_53_2022;
CREATE TABLE parseo.trama_53_2022
(
    CONSTRAINT pk_trama_53_2022 PRIMARY KEY (id),
    CONSTRAINT trama_53_2022_fecha_check CHECK (fecha >= '2022-12-31 00:00:00'::timestamp without time zone AND fecha < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (parseo.trama_1) TABLESPACE pg_default;

ALTER TABLE parseo.trama_53_2022 OWNER to postgres;
GRANT ALL ON TABLE parseo.trama_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE parseo.trama_53_2022 TO consultor;
GRANT ALL ON TABLE parseo.trama_53_2022 TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE parseo.trama_53_2022 TO web;

-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ESQUEMA SEGUIMIENTO

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.calculo_carga_53_2022;
CREATE TABLE seguimiento_datos.calculo_carga_53_2022
(
    CONSTRAINT pk_calculo_carga_53_2022 PRIMARY KEY (id),
    CONSTRAINT calculo_carga_53_2022_updatetime_check CHECK (updatetime >= '2022-12-31 00:00:00'::timestamp without time zone AND updatetime < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.calculo_carga) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.calculo_carga_53_2022 OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.calculo_carga_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE seguimiento_datos.calculo_carga_53_2022 TO consultor;
GRANT ALL ON TABLE seguimiento_datos.calculo_carga_53_2022 TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.calculo_carga_53_2022 TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.calculo_carga_53_2022 TO web;

DROP INDEX IF EXISTS seguimiento_datos.ind_vh_up_calculo_carga_53_2022;
CREATE INDEX ind_vh_up_calculo_carga_53_2022
    ON seguimiento_datos.calculo_carga_53_2022 USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST, skiped ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.calculos_combustible_53_2022;
CREATE TABLE seguimiento_datos.calculos_combustible_53_2022
(
    CONSTRAINT pk_calculos_combustible_53_2022 PRIMARY KEY (id),
    CONSTRAINT fk_estado_combustible_53_2022 FOREIGN KEY (estado_combustible)
        REFERENCES public.estado_tipo_variable (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE RESTRICT,
    CONSTRAINT fk_vehiculo_combustible_53_2022 FOREIGN KEY (vehiculo)
        REFERENCES public.vehiculo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE RESTRICT,
    CONSTRAINT calculos_combustible_53_2022_updatetime_check CHECK (updatetime >= '2022-12-31 00:00:00'::timestamp without time zone AND updatetime < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.calculos_combustible) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.calculos_combustible_53_2022 OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.calculos_combustible_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE seguimiento_datos.calculos_combustible_53_2022 TO consultor;
GRANT ALL ON TABLE seguimiento_datos.calculos_combustible_53_2022 TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.calculos_combustible_53_2022 TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.calculos_combustible_53_2022 TO web;

DROP INDEX IF EXISTS seguimiento_datos.calculo_cmb_posicion_53_2022;
CREATE INDEX calculo_cmb_posicion_53_2022
    ON seguimiento_datos.calculos_combustible_53_2022 USING btree
    (posicion ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.fki_estado_53_2022;
CREATE INDEX fki_estado_53_2022
    ON seguimiento_datos.calculos_combustible_53_2022 USING btree
    (estado_combustible ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.ind_sk_st_53_2022;
CREATE INDEX ind_sk_st_53_2022
    ON seguimiento_datos.calculos_combustible_53_2022 USING btree
    (estado_combustible ASC NULLS LAST, skiped ASC NULLS LAST, vehiculo ASC NULLS LAST)
    TABLESPACE pg_default
    WHERE estado_combustible <> 8 AND skiped = false;

DROP INDEX IF EXISTS seguimiento_datos.ind_vh_up_sk_53_2022;
CREATE INDEX ind_vh_up_sk_53_2022
    ON seguimiento_datos.calculos_combustible_53_2022 USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST, skiped ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_evento_53_2022;
CREATE TABLE seguimiento_datos.historial_evento_53_2022
(
    CONSTRAINT pk_historial_evento_53_2022 PRIMARY KEY (id),
    CONSTRAINT historial_evento_53_2022_updatetime_check CHECK (updatetime >= '2022-12-31 00:00:00'::timestamp without time zone AND updatetime < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_evento_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_evento_53_2022 OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_evento_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE seguimiento_datos.historial_evento_53_2022 TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_evento_53_2022 TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_evento_53_2022 TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_evento_53_2022 TO web;

DROP INDEX IF EXISTS seguimiento_datos.idx_pos_historial_evento_53_2022;
CREATE INDEX idx_pos_historial_evento_53_2022
    ON seguimiento_datos.historial_evento_53_2022 USING btree
    (posicion ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.idx_vh_up_tv_historial_evento_53_2022;
CREATE INDEX idx_vh_up_tv_historial_evento_53_2022
    ON seguimiento_datos.historial_evento_53_2022 USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST, tipo_evento ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_extra_53_2022;
CREATE TABLE seguimiento_datos.historial_extra_53_2022
(
    CONSTRAINT pk_historial_extra_53_2022 PRIMARY KEY (id),
    CONSTRAINT historial_extra_53_2022_updatetime_check CHECK (updatetime >= '2022-12-31 00:00:00'::timestamp without time zone AND updatetime < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_extra_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_extra_53_2022 OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_extra_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE seguimiento_datos.historial_extra_53_2022 TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_extra_53_2022 TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_extra_53_2022 TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_extra_53_2022 TO web;

DROP INDEX IF EXISTS seguimiento_datos.idx_pos_tv_historial_extra_53_2022;
CREATE INDEX idx_pos_tv_historial_extra_53_2022
    ON seguimiento_datos.historial_extra_53_2022 USING btree
    (posicion ASC NULLS LAST, tipo_variable ASC NULLS LAST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.idx_vh_up_tv_historial_extra_53_2022;
CREATE INDEX idx_vh_up_tv_historial_extra_53_2022
    ON seguimiento_datos.historial_extra_53_2022 USING btree
    (vehiculo ASC NULLS LAST, tipo_variable ASC NULLS LAST, updatetime ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_novedades_viaje_53_2022;

CREATE TABLE seguimiento_datos.historial_novedades_viaje_53_2022
(
    CONSTRAINT pk_historial_novedades_viaje_53_2022 PRIMARY KEY (id),
    CONSTRAINT historial_novedades_viaje_53_2022_fecha_check CHECK (fecha >= '2022-12-31 00:00:00'::timestamp without time zone AND fecha < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_novedades_viaje_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_novedades_viaje_53_2022 OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_novedades_viaje_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE seguimiento_datos.historial_novedades_viaje_53_2022 TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_novedades_viaje_53_2022 TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_novedades_viaje_53_2022 TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_novedades_viaje_53_2022 TO web;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_posicion_53_2022;
CREATE TABLE seguimiento_datos.historial_posicion_53_2022
(
    CONSTRAINT pk_historial_posicion_53_2022 PRIMARY KEY (id),
    CONSTRAINT historial_posicion_53_2022_updatetime_check CHECK (updatetime >= '2022-12-31 00:00:00'::timestamp without time zone AND updatetime < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_posicion_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_posicion_53_2022 OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_posicion_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE seguimiento_datos.historial_posicion_53_2022 TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_posicion_53_2022 TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_posicion_53_2022 TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_posicion_53_2022 TO web;

DROP INDEX IF EXISTS seguimiento_datos.idx_historial_posicion__53_2022_uptm;
CREATE INDEX idx_historial_posicion__53_2022_uptm
    ON seguimiento_datos.historial_posicion_53_2022 USING btree
    (updatetime DESC NULLS FIRST)
    TABLESPACE pg_default;

DROP INDEX IF EXISTS seguimiento_datos.idx_historial_posicion__53_2022_vh_uptm;
CREATE INDEX idx_historial_posicion__53_2022_vh_uptm
    ON seguimiento_datos.historial_posicion_53_2022 USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS seguimiento_datos.historial_viaje_53_2022;
CREATE TABLE seguimiento_datos.historial_viaje_53_2022
(
    CONSTRAINT pk_historial_viaje_53_2022 PRIMARY KEY (id),
    CONSTRAINT historial_viaje_53_2022_updatetime_check CHECK (fecha_creacion >= '2022-12-31 00:00:00'::timestamp without time zone AND fecha_creacion < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (seguimiento_datos.historial_viaje_1) TABLESPACE pg_default;

ALTER TABLE seguimiento_datos.historial_viaje_53_2022 OWNER to postgres;
GRANT ALL ON TABLE seguimiento_datos.historial_viaje_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE seguimiento_datos.historial_viaje_53_2022 TO consultor;
GRANT ALL ON TABLE seguimiento_datos.historial_viaje_53_2022 TO postgres;
GRANT SELECT ON TABLE seguimiento_datos.historial_viaje_53_2022 TO sytianalist;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE seguimiento_datos.historial_viaje_53_2022 TO web;

DROP INDEX IF EXISTS seguimiento_datos.index_historial_viaje_53_2022;
CREATE INDEX index_historial_viaje_53_2022
    ON seguimiento_datos.historial_viaje_53_2022 USING btree
    (vehiculo ASC NULLS LAST, ruta ASC NULLS LAST, viaje ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ESQUEMA CONSOLIDADOS

-- FRECUENCIA DE LA TABLA: Semanal <<<<<<<<<<<<<<<<<<<<

DROP TABLE IF EXISTS consolidados.historial_consolidado_53_2022;
CREATE TABLE consolidados.historial_consolidado_53_2022
(
    CONSTRAINT pk_historial_consolidado_53_2022 PRIMARY KEY (id),
    CONSTRAINT fk_cnd_historial_consolidado_53_2022 FOREIGN KEY (conductor)
        REFERENCES conductores.conductor (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE RESTRICT,
    CONSTRAINT fk_vehiculo_historial_consolidado_53_2022 FOREIGN KEY (vehiculo)
        REFERENCES public.vehiculo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE RESTRICT,
    CONSTRAINT historial_consolidado_53_2022_updatetime_check CHECK (updatetime >= '2022-12-31 00:00:00'::timestamp without time zone AND updatetime < '2023-01-07 00:00:00'::timestamp without time zone)
) INHERITS (consolidados.historial_consolidado_1) TABLESPACE pg_default;

ALTER TABLE consolidados.historial_consolidado_53_2022 OWNER to postgres;
GRANT ALL ON TABLE consolidados.historial_consolidado_53_2022 TO "adminTLC";
GRANT SELECT ON TABLE consolidados.historial_consolidado_53_2022 TO consultor;
GRANT ALL ON TABLE consolidados.historial_consolidado_53_2022 TO postgres;
GRANT DELETE, UPDATE, SELECT, INSERT ON TABLE consolidados.historial_consolidado_53_2022 TO web;

DROP INDEX IF EXISTS consolidados.idx_fch_vh_historial_consolidado_53_2022;
CREATE INDEX idx_fch_vh_historial_consolidado_53_2022
    ON consolidados.historial_consolidado_53_2022 USING btree
    (vehiculo ASC NULLS LAST, updatetime ASC NULLS LAST, visible ASC NULLS LAST)
    TABLESPACE pg_default;

-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&