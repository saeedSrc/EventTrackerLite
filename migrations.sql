CREATE TABLE employees (
                           employee_id INT PRIMARY KEY AUTO_INCREMENT,
                           employee_name VARCHAR(255),
                           employee_mail VARCHAR(255)
);

CREATE TABLE events (
                        event_id INT PRIMARY KEY AUTO_INCREMENT,
                        event_name VARCHAR(255)
);

CREATE TABLE bookings (
                          participation_id INT PRIMARY KEY AUTO_INCREMENT,
                          employee_id INT,
                          event_id INT,
                          participation_fee DECIMAL(10, 2),
                          event_date DATETIME,
                          version VARCHAR(20),
                          FOREIGN KEY (employee_id) REFERENCES employees(employee_id),
                          FOREIGN KEY (event_id) REFERENCES events(event_id)
);
