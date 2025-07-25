DROP TRIGGER IF EXISTS trg_aud_plan_de_desarrollos_insert;
DROP TRIGGER IF EXISTS trg_aud_plan_de_desarrollos_update;
DROP TRIGGER IF EXISTS trg_aud_plan_de_desarrollos_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_plan_de_desarrollos_insert
AFTER INSERT ON plan_de_desarrollos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'plan_de_desarrollos', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_plan_de_desarrollos_update
AFTER UPDATE ON plan_de_desarrollos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'plan_de_desarrollos', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_plan_de_desarrollos_delete
AFTER DELETE ON plan_de_desarrollos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'plan_de_desarrollos', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_permisos_insert;
DROP TRIGGER IF EXISTS trg_aud_permisos_update;
DROP TRIGGER IF EXISTS trg_aud_permisos_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_permisos_insert
AFTER INSERT ON permisos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'permisos', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_permisos_update
AFTER UPDATE ON permisos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'permisos', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_permisos_delete
AFTER DELETE ON permisos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'permisos', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_secretarias_insert;
DROP TRIGGER IF EXISTS trg_aud_secretarias_update;
DROP TRIGGER IF EXISTS trg_aud_secretarias_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_secretarias_insert
AFTER INSERT ON secretarias
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'secretarias', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_secretarias_update
AFTER UPDATE ON secretarias
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'secretarias', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_secretarias_delete
AFTER DELETE ON secretarias
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'secretarias', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_funciones_sec_insert;
DROP TRIGGER IF EXISTS trg_aud_funciones_sec_update;
DROP TRIGGER IF EXISTS trg_aud_funciones_sec_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_funciones_sec_insert
AFTER INSERT ON funciones_sec
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'funciones_sec', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_funciones_sec_update
AFTER UPDATE ON funciones_sec
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'funciones_sec', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_funciones_sec_delete
AFTER DELETE ON funciones_sec
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'funciones_sec', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_perfiles_insert;
DROP TRIGGER IF EXISTS trg_aud_perfiles_update;
DROP TRIGGER IF EXISTS trg_aud_perfiles_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_perfiles_insert
AFTER INSERT ON perfiles
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'perfiles', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_perfiles_update
AFTER UPDATE ON perfiles
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'perfiles', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_perfiles_delete
AFTER DELETE ON perfiles
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'perfiles', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_funcionarios_insert;
DROP TRIGGER IF EXISTS trg_aud_funcionarios_update;
DROP TRIGGER IF EXISTS trg_aud_funcionarios_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_funcionarios_insert
AFTER INSERT ON funcionarios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'funcionarios', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_funcionarios_update
AFTER UPDATE ON funcionarios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'funcionarios', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_funcionarios_delete
AFTER DELETE ON funcionarios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'funcionarios', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_tipos_insert;
DROP TRIGGER IF EXISTS trg_aud_tipos_update;
DROP TRIGGER IF EXISTS trg_aud_tipos_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_tipos_insert
AFTER INSERT ON tipos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'tipos', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_tipos_update
AFTER UPDATE ON tipos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'tipos', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_tipos_delete
AFTER DELETE ON tipos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'tipos', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_tags_insert;
DROP TRIGGER IF EXISTS trg_aud_tags_update;
DROP TRIGGER IF EXISTS trg_aud_tags_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_tags_insert
AFTER INSERT ON tags
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'tags', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_tags_update
AFTER UPDATE ON tags
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'tags', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_tags_delete
AFTER DELETE ON tags
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'tags', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_publicaciones_insert;
DROP TRIGGER IF EXISTS trg_aud_publicaciones_update;
DROP TRIGGER IF EXISTS trg_aud_publicaciones_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_publicaciones_insert
AFTER INSERT ON publicaciones
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'publicaciones', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_publicaciones_update
AFTER UPDATE ON publicaciones
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'publicaciones', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_publicaciones_delete
AFTER DELETE ON publicaciones
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'publicaciones', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_publicacion_documentos_insert;
DROP TRIGGER IF EXISTS trg_aud_publicacion_documentos_update;
DROP TRIGGER IF EXISTS trg_aud_publicacion_documentos_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_publicacion_documentos_insert
AFTER INSERT ON publicacion_documentos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'publicacion_documentos', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_publicacion_documentos_update
AFTER UPDATE ON publicacion_documentos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'publicacion_documentos', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_publicacion_documentos_delete
AFTER DELETE ON publicacion_documentos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'publicacion_documentos', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_publicacion_fotos_insert;
DROP TRIGGER IF EXISTS trg_aud_publicacion_fotos_update;
DROP TRIGGER IF EXISTS trg_aud_publicacion_fotos_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_publicacion_fotos_insert
AFTER INSERT ON publicacion_fotos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'publicacion_fotos', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_publicacion_fotos_update
AFTER UPDATE ON publicacion_fotos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'publicacion_fotos', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_publicacion_fotos_delete
AFTER DELETE ON publicacion_fotos
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'publicacion_fotos', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_dependencias_insert;
DROP TRIGGER IF EXISTS trg_aud_dependencias_update;
DROP TRIGGER IF EXISTS trg_aud_dependencias_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_dependencias_insert
AFTER INSERT ON dependencias
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'dependencias', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_dependencias_update
AFTER UPDATE ON dependencias
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'dependencias', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_dependencias_delete
AFTER DELETE ON dependencias
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'dependencias', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_tramites_insert;
DROP TRIGGER IF EXISTS trg_aud_tramites_update;
DROP TRIGGER IF EXISTS trg_aud_tramites_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_tramites_insert
AFTER INSERT ON tramites
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'tramites', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_tramites_update
AFTER UPDATE ON tramites
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'tramites', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_tramites_delete
AFTER DELETE ON tramites
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'tramites', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_servicios_insert;
DROP TRIGGER IF EXISTS trg_aud_servicios_update;
DROP TRIGGER IF EXISTS trg_aud_servicios_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_servicios_insert
AFTER INSERT ON servicios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'servicios', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_servicios_update
AFTER UPDATE ON servicios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'servicios', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_servicios_delete
AFTER DELETE ON servicios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'servicios', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_asignaciones_funcionarios_insert;
DROP TRIGGER IF EXISTS trg_aud_asignaciones_funcionarios_update;
DROP TRIGGER IF EXISTS trg_aud_asignaciones_funcionarios_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_asignaciones_funcionarios_insert
AFTER INSERT ON asignaciones_funcionarios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'asignaciones_funcionarios', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_asignaciones_funcionarios_update
AFTER UPDATE ON asignaciones_funcionarios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'asignaciones_funcionarios', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_asignaciones_funcionarios_delete
AFTER DELETE ON asignaciones_funcionarios
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'asignaciones_funcionarios', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;
DROP TRIGGER IF EXISTS trg_aud_asignaciones_organizacionales_insert;
DROP TRIGGER IF EXISTS trg_aud_asignaciones_organizacionales_update;
DROP TRIGGER IF EXISTS trg_aud_asignaciones_organizacionales_delete;
DELIMITER $$
CREATE TRIGGER trg_aud_asignaciones_organizacionales_insert
AFTER INSERT ON asignaciones_organizacionales
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_nuevos
  )
  VALUES (
    'asignaciones_organizacionales', 'INSERT', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_asignaciones_organizacionales_update
AFTER UPDATE ON asignaciones_organizacionales
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos, valores_nuevos
  )
  VALUES (
    'asignaciones_organizacionales', 'UPDATE', CAST(NEW.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL')),
    JSON_OBJECT('id', IFNULL(CAST(NEW.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER $$
CREATE TRIGGER trg_aud_asignaciones_organizacionales_delete
AFTER DELETE ON asignaciones_organizacionales
FOR EACH ROW
BEGIN
  INSERT INTO auditoria (
    tabla_afectada, operacion, id_registro, usuario, fecha_hora, valores_previos
  )
  VALUES (
    'asignaciones_organizacionales', 'DELETE', CAST(OLD.id AS CHAR), CURRENT_USER(), NOW(6),
    JSON_OBJECT('id', IFNULL(CAST(OLD.id AS CHAR), 'NULL'))
  );
END$$
DELIMITER ;

SHOW TRIGGERS FROM alcaldia;

SELECT * FROM auditoria ORDER BY fecha_hora DESC;


SELECT
  TRIGGER_NAME,
  EVENT_OBJECT_TABLE AS table_name,
  EVENT_MANIPULATION AS event,
  ACTION_TIMING AS timing,
  ACTION_STATEMENT AS definition
FROM information_schema.TRIGGERS
WHERE TRIGGER_SCHEMA = 'alcaldia'
ORDER BY EVENT_OBJECT_TABLE, EVENT_MANIPULATION;
