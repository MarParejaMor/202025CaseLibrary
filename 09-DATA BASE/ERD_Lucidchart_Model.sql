-- Tabla de cuentas de usuario
CREATE TABLE ACCOUNT (
    account_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone_number VARCHAR(20)
);

-- Perfil relacionado uno a uno con cada cuenta
CREATE TABLE PROFILE (
    profile_id INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT,
    account_id INT UNIQUE,
    FOREIGN KEY (account_id) REFERENCES ACCOUNT(account_id) ON DELETE CASCADE
);

-- Procesos legales asociados a una cuenta
CREATE TABLE PROCESS (
    process_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(100),
    offense VARCHAR(255),
    last_update DATE,
    denouncer VARCHAR(255),
    coordinator VARCHAR(255),
    canton VARCHAR(100),
    province VARCHAR(100),
    account_id INT,
    process_status ENUM('in progress', 'finished', 'suspended', 'not started') DEFAULT 'not started',
    start_date DATE,
    end_date DATE,
    process_number VARCHAR(50),
    process_type VARCHAR(100),
    process_description TEXT,

    FOREIGN KEY (account_id) REFERENCES ACCOUNT(account_id) ON DELETE SET NULL
);

-- Consejos legales asociados a un proceso
CREATE TABLE LEGAL_ADVICE (
    advice_id INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT NOT NULL,
    process_id INT,
    FOREIGN KEY (process_id) REFERENCES PROCESS(process_id) ON DELETE CASCADE
);

-- Evidencias asociadas a un proceso
CREATE TABLE EVIDENCE (
    evidence_id INT PRIMARY KEY AUTO_INCREMENT,
    evidence_type VARCHAR(100),
    file_path VARCHAR(255),
    process_id INT,
    FOREIGN KEY (process_id) REFERENCES PROCESS(process_id) ON DELETE CASCADE
);

-- Línea de tiempo de un proceso
CREATE TABLE TIMELINE (
    timeline_id INT PRIMARY KEY AUTO_INCREMENT,
    number_events INT DEFAULT 0,
    process_id INT UNIQUE,
    FOREIGN KEY (process_id) REFERENCES PROCESS(process_id) ON DELETE CASCADE
);

-- Eventos dentro de una línea de tiempo
CREATE TABLE EVENT (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    date DATE,
    order_index INT,
    timeline_id INT,
    FOREIGN KEY (timeline_id) REFERENCES TIMELINE(timeline_id) ON DELETE CASCADE
);

-- Observaciones hechas sobre un proceso
CREATE TABLE OBSERVATION (
    observation_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    content TEXT,
    process_id INT,
    FOREIGN KEY (process_id) REFERENCES PROCESS(process_id) ON DELETE CASCADE
);

-- Citas asociadas a una cuenta
CREATE TABLE APPOINTMENT (
    appointment_id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(100),
    date DATE NOT NULL,
    description TEXT,
    contact_info VARCHAR(255),
    account_id INT,
    FOREIGN KEY (account_id) REFERENCES ACCOUNT(account_id) ON DELETE SET NULL
);

-- Recordatorios de citas
CREATE TABLE REMINDER (
    reminder_id INT PRIMARY KEY AUTO_INCREMENT,
    date_time DATETIME NOT NULL,
    active_flag BOOLEAN DEFAULT TRUE,
    appointment_id INT UNIQUE,
    FOREIGN KEY (appointment_id) REFERENCES APPOINTMENT(appointment_id) ON DELETE CASCADE
);

DELIMITER //

CREATE TRIGGER set_process_number
BEFORE INSERT ON PROCESS
FOR EACH ROW
BEGIN
    DECLARE next_id INT;

    SELECT AUTO_INCREMENT INTO next_id
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_NAME = 'PROCESS' AND TABLE_SCHEMA = DATABASE();

    SET NEW.process_number = CONCAT('PROC-', LPAD(next_id, 4, '0'));
END;
//

DELIMITER ;
