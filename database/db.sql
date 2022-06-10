CREATE DATABASE oprasdb;

USE oprasdb;

CREATE TABLE roles(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role_type VARCHAR(10) NOT NULL
);

##insert default roles
INSERT INTO
    roles (role_type)
VALUES
    ('admin'),
    ('supervisor'),
    ('staff'),
    ('DVC'),
    ('HR');

CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    middlename VARCHAR(30) NULL,
    surname VARCHAR(30) NOT NULL,
    email VARCHAR(60) NOT NULL UNIQUE,
    phone VARCHAR(10) NOT NULL UNIQUE,
    sex VARCHAR(1) NOT NULL,
    faculty VARCHAR(10) NOT NULL,
    date_of_birth DATE NOT NULL,
    password VARCHAR(100) NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles (id)
);

##set default admin account
INSERT INTO
    users
VALUES
    (
        1,
        'admin',
        'admin',
        'admin',
        'admin@mzumbe.ac.tz',
        '000000000',
        'F',
        'FST',
        '1888-07-01',
        sha1('admin123'),
        1
    ),
    (
        2,
        'Dr. Hassan',
        'M',
        'Kilowoko',
        'hassan@mzumbe.ac.tz',
        '0768950946',
        'M',
        'FST',
        '1992-10-12',
        sha1('mzumbehassan006'),
        2
    ),
    (
        3,
        'Dr. Rukia',
        '',
        'Chombo',
        'rukia@mzumbe.ac.tz',
        '0678465904',
        'F',
        'FST',
        '1998-12-07',
        sha1('mzumberukia123'),
        3
    ),
    (
        4,
        'Prof. John',
        'Smith',
        'Doe',
        'johndoe@mzumbe.ac.tz',
        '0657345678',
        'M',
        'FST',
        '1969-12-03',
        sha1('johndoemzumbe001'),
        4
    ),
    (
        5,
        'Miss. Prisca',
        'N',
        'Nkunungu',
        'priscan@mzumbe.ac.tz',
        '0786567849',
        'F',
        'SOPAM',
        '1997-06-30',
        sha1('priscamzumbe3445'),
        5
    );

CREATE TABLE personal_details(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    present_station VARCHAR(30) NOT NULL,
    qualification VARCHAR(30) NOT NULL,
    duty_post VARCHAR(20) NOT NULL,
    substantive_post VARCHAR(20) NOT NULL,
    previous_appointment DATE NOT NULL,
    present_appointment DATE NOT NULL,
    salary_scale VARCHAR(10) NOT NULL,
    period_served VARCHAR(20) NOT NULL,
    profile_photo VARCHAR(100) NOT NULL,
    user_id INT NOT NULL UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE opras_year (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    _year VARCHAR(20) NOT NULL
);

INSERT INTO
    opras_year (_year)
VALUES
    ('2020'),
    ('2021'),
    ('2022'),
    ('2023');

CREATE TABLE year_preview (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    year_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (year_id) REFERENCES opras_year (id) ON DELETE RESTRICT
);

CREATE TABLE agreement(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    agreed_objectives VARCHAR(200) NOT NULL,
    agreed_criteria VARCHAR(200) NOT NULL,
    agreed_resources VARCHAR(200) NOT NULL,
    agreed_targets VARCHAR(200) NOT NULL,
    aYear INT NOT NULL,
    FOREIGN KEY (aYear) REFERENCES year_preview (id) ON DELETE RESTRICT
);

CREATE TABLE mid_review(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    agreement_id INT NOT NULL,
    progress_made VARCHAR(200) NULL,
    factors_affecting VARCHAR(200) NULL,
    FOREIGN KEY (agreement_id) REFERENCES agreement (id) ON DELETE CASCADE
);

CREATE TABLE revised_objectives(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    agreement_id INT NOT NULL,
    revised_objectives VARCHAR(500) NULL,
    revised_performance VARCHAR(500) NULL,
    revised_criteria VARCHAR(500) NULL,
    revised_resources VARCHAR(500) NULL,
    FOREIGN KEY (agreement_id) REFERENCES agreement (id) ON DELETE CASCADE
);

CREATE TABLE annual_performance_review(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    mid_review_id INT NOT NULL,
    staff_mark INT NULL,
    supervisor_mark INT NULL,
    agreed_mark VARCHAR(3) NULL,
    FOREIGN KEY (mid_review_id) REFERENCES mid_review (id) ON DELETE CASCADE
);

CREATE TABLE main_factors(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    factors VARCHAR(100) NOT NULL
);

##insert default factors
INSERT INTO
    main_factors (factors)
VALUES
    ('WORKING RELATIONSHIPS'),
    ('COMMUNICATION AND LISTENING'),
    ('MANAGEMENT AND LEADERSHIP'),
    ('PERFORMANCE INTERMS OF QUALITY'),
    ('RESPONSIBILITY AND JUDGEMENT'),
    ('CUSTOMER FOCUS'),
    ('LOYALITY'),
    ('INTEGRITY');

CREATE TABLE quality_attributes(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quality VARCHAR(100) NOT NULL,
    factor_id INT NOT NULL,
    staff_mark INT NULL,
    supervisor_mark INT NULL,
    agreed_mark VARCHAR(3) NULL,
    FOREIGN KEY (factor_id) REFERENCES main_factors (id)
);

##insert default quality_attributes
INSERT INTO
    quality_attributes (quality, factor_id)
VALUES
    ('Ability to work in team', 1),
    ('Ability to get on with other staff', 1),
    ('Ability to gain respect from others', 1),
    ('Ability to express in writing', 2),
    ('Ability to express orally', 2),
    ('Ability to listen and comprehend', 2),
    ('Ability to train and develop subordinates', 2),
    ('Ability to plan and organize', 3),
    (
        'Ability to lead,motivate and resolve conflicts',
        3
    ),
    ('Ability to initiate and motivate', 3),
    (
        'Ability to deliver accurate and high quality output timely',
        4
    ),
    ('Ability for resilience and persistence', 4),
    ('Ability to meet demand', 4),
    ('Ability to handle extra work', 4),
    ('Ability to accept and fulfil responsiblity', 5),
    ('Ability to make right decisions', 5),
    ('Ability to respond well to the customer', 6),
    ('Ability to demonstrate follower ship skills', 7),
    (
        'Ability to provide ongoing support to supervisor',
        7
    ),
    (
        'Ability to comply with lawful instructions of supervisors',
        7
    ),
    (
        'Ability to devote working time exclusively to work related duties',
        8
    ),
    (
        'Ability to provide quality services without need for any inducements',
        8
    ),
    (
        'Ability to apply knowledge abilities to benefit government and not for personal gains',
        8
    );

CREATE TABLE opras(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    aYear INT NOT NULL UNIQUE,
    supervisor_id INT NOT NULL,
    supervisor_comment VARCHAR(200) NULL,
    dvc_comment VARCHAR(200) NULL,
    FOREIGN KEY (aYear) REFERENCES year_preview (id),
    FOREIGN KEY (supervisor_id) REFERENCES users (id)
);
