# main

//DATABASE NAME: - maindrdo

//create table for employee:- 
CREATE TABLE employee (
    id INT UNIQYE,
    emid VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    gender VARCHAR(10),
    cadre VARCHAR(100),
    post VARCHAR(100),
    postin DATE,
    postout DATE,
    dob DATE,
    phone VARCHAR(20),
    address VARCHAR(255),
    education VARCHAR(255),
    image VARCHAR(255)
);

//create event table :- 
CREATE TABLE event (
    id INT PRIMARY KEY,
    eid INT,
    ename VARCHAR(255),
    edepartment VARCHAR(100),
    eplace VARCHAR(100),
    estart DATE,
    eend DATE,
    estatus VARCHAR(50),
    eimage VARCHAR(255)
);

//create employee_event table :- 
CREATE TABLE `employee_event` (
    `employee_id` VARCHAR(255),
    `event_id` INT,
    FOREIGN KEY (`employee_id`) REFERENCES `employee` (`emid`) ON DELETE CASCADE,
    FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
    PRIMARY KEY (`employee_id`, `event_id`)
);
