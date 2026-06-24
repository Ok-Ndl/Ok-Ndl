USE hospital;

INSERT INTO users (id, full_name, email, password_hash, role_id, status) VALUES
(1, 'System Administrator', 'admin@example.com', '$2y$10$LnZ4EP1SotMbtn59vCPnTO9SzHIgSdoU4TXlUpsAYVGuUrZ6QcG0u', 1, 'active'),
(2, 'Dr. Jane Smith', 'doctor@example.com', '$2y$10$LnZ4EP1SotMbtn59vCPnTO9SzHIgSdoU4TXlUpsAYVGuUrZ6QcG0u', 2, 'active'),
(3, 'Patient One', 'patient@example.com', '$2y$10$LnZ4EP1SotMbtn59vCPnTO9SzHIgSdoU4TXlUpsAYVGuUrZ6QcG0u', 3, 'active');

INSERT INTO patients (id, user_id, phone, date_of_birth, gender, address) VALUES
(1, 3, '0712345678', '1995-03-12', 'Female', '12 Main Road');

INSERT INTO doctors (id, user_id, specialty, phone, license_number) VALUES
(1, 2, 'General Medicine', '0723456789', 'LIC-1001');

INSERT INTO appointments (id, patient_id, doctor_id, appointment_date, appointment_time, status, notes) VALUES
(1, 1, 1, '2026-06-08', '10:00:00', 'pending', 'Routine consultation'),
(2, 1, 1, '2026-06-11', '14:00:00', 'confirmed', 'Follow-up');

INSERT INTO medical_records (id, patient_id, doctor_id, diagnosis, prescription, notes) VALUES
(1, 1, 1, 'Routine checkup', 'Paracetamol as needed', 'Patient reports mild fatigue');
