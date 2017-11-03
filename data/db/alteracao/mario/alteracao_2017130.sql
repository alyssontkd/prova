ALTER TABLE prova 
ADD COLUMN bo_prova_definitiva CHAR(1) 
COMMENT "Coluna designada para identificar provas ja aplicadas";

-- Permissoes do Modulo Provas (Administrador, Professor, Coordenacao)
-- Action: aplicar-temporizador-questao-prova-ajax
-- Action: liberar-temporizador-questao-prova-ajax
-- Action: marcar-avaliacao-como-aplicada  