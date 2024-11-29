INSERT INTO roles (id, name, created_at, updated_at) VALUES
(1, 'Super Admin', NOW(), NOW()),
(2, 'Manager', NOW(), NOW()),
(3, 'Employee', NOW(), NOW());

INSERT INTO companies (id, name, email, phone, created_at, updated_at) VALUES
(1, 'PT Company Example', 'contact@company.test', '021-12345678', NOW(), NOW());

-- User dengan peran Super Admin
INSERT INTO users (id, name, email, email_verified_at, password, role_id, remember_token, created_at, updated_at) VALUES
(1, 'Super Admin', 'admin@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 1, NULL, NOW(), NOW());

-- User dengan peran Manager
INSERT INTO users (id, name, email, email_verified_at, password, role_id, remember_token, created_at, updated_at) VALUES
(2, 'Hamilton Eastwood', 'manager@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 2, NULL, NOW(), NOW());

-- User dengan peran Employee
INSERT INTO users (id, name, email, email_verified_at, password, role_id, remember_token, created_at, updated_at) VALUES
(3, 'Kingsly Gormally', 'employee@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW());

-- User dengan peran Employee
INSERT INTO users (id, name, email, email_verified_at, password, role_id, remember_token, created_at, updated_at) VALUES
(4, 'Charmion Drugan', 'charmiondrugan@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW()),
(5, 'Orly Addionisio', 'orlyaddionisio@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW()),
(6, 'Iggy Denerley', 'iggydenerley@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW()),
(7, 'Malissa McCollum', 'malissamccollum@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW()),
(8, 'Kayla Eannetta', 'kaylaeannetta@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW()),
(9, 'Lindi MacNucator', 'lindimacnucator@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW()),
(10, 'Edgar Fitchen', 'edgarfitchen@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW()),
(11, 'Yale Powton', 'yalepowton@example.test', NULL, '$2y$12$SGpcvPrGjsRZ/pihGlrYge11at8grz/UXTAvQN6FYT6hvtr5FCyBm', 3, NULL, NOW(), NOW());

-- Employee 1 (Manager)
INSERT INTO employees (id, company_id, name, email, phone, address, account_id, created_at, updated_at) VALUES
(1, 1, 'Hamilton Eastwood', 'manager@example.test', '+623965976642', '94 Maywood Plaza', 2, NOW(), NOW());

-- Employee 2 sampai Employee 10 (Employee)
INSERT INTO employees (id, company_id, name, email, phone, address, account_id, created_at, updated_at) VALUES
(2, 1, 'Kingsly Gormally', 'employee@example.test', '+625388144967', '14 Talisman Place', 3, NOW(), NOW());

INSERT INTO employees (id, company_id, name, email, phone, address, account_id, created_at, updated_at) VALUES
(3, 1, 'Charmion Drugan', 'charmiondrugan@example.test', '+622369384806', '7 Linden Court', 4, NOW(), NOW()),
(4, 1, 'Orly Addionisio', 'orlyaddionisio@example.test', '+622761689364', '35 Darwin Parkway', 5, NOW(), NOW()),
(5, 1, 'Iggy Denerley', 'iggydenerley@example.test', '+626362953946', '180 Donald Junction', 6, NOW(), NOW()),
(6, 1, 'Malissa McCollum', 'malissamccollum@example.test', '+622793704724', '5 Stuart Alley', 7, NOW(), NOW()),
(7, 1, 'Kayla Eannetta', 'kaylaeannetta@example.test', '+625823268263', '99637 Stoughton Point', 8, NOW(), NOW()),
(8, 1, 'Lindi MacNucator', 'lindimacnucator@example.test', '+625719318124', '1730 Anniversary Lane', 9, NOW(), NOW()),
(9, 1, 'Edgar Fitchen', 'edgarfitchen@example.test', '+621807652478', '851 School Way', 10, NOW(), NOW()),
(10, 1, 'Yale Powton', 'yalepowton@example.test', '+622304168357', '0803 Elmside Hill', 11, NOW(), NOW());
