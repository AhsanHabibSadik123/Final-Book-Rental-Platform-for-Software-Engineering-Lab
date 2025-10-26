create database bookstore;
use bookstore;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(255),
    address TEXT,
    bio TEXT,
    role ENUM('admin','user') DEFAULT 'user',
    is_verified TINYINT(1) DEFAULT 0,
    wallet DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE books (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) UNIQUE,
    genre VARCHAR(100) NOT NULL,
    description TEXT,
    `condition` ENUM('new', 'good', 'fair', 'poor') NOT NULL,
    rental_price_per_day DECIMAL(8,2) NOT NULL,
    security_deposit DECIMAL(10,2) DEFAULT 0,
    lender_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255),
    status ENUM('available', 'rented', 'maintenance', 'unavailable') DEFAULT 'available',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (lender_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE rentals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    book_id BIGINT UNSIGNED NOT NULL,
    borrower_id BIGINT UNSIGNED NOT NULL,
    lender_id BIGINT UNSIGNED NOT NULL,
    rental_start_date DATE NOT NULL,
    rental_end_date DATE NOT NULL,
    actual_return_date DATE,
    daily_rate DECIMAL(8,2) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    security_deposit DECIMAL(10,2) DEFAULT 0,
    status ENUM('pending', 'active', 'completed', 'overdue', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (borrower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lender_id) REFERENCES users(id) ON DELETE CASCADE
);


INSERT INTO users (name, email, password, phone, address, bio, role, is_verified, wallet, created_at, updated_at) VALUES
('admin',  'admin@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000005', 'Admin office', 'I am Admin', 'admin', 0, 0.00, NOW(), NOW()),
('user1',  'u1@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000005', 'Dhaka', 'I am user1', 'user', 0, 0.00, NOW(), NOW()),
('user2',  'u2@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000005', 'Dhaka', 'I am user2', 'user', 0, 0.00, NOW(), NOW()),
('user3',  'u3@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000005', 'Dhaka', 'I am user3', 'user', 0, 0.00, NOW(), NOW()),
('user4',  'u4@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000005', 'Dhaka', 'I am user4', 'user', 0, 0.00, NOW(), NOW()),
('user5',  'u5@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000005', 'Dhaka', 'I am user5', 'user', 0, 0.00, NOW(), NOW()),
('user6',  'u6@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000006', 'Chittagong', 'I am user6', 'user', 0, 0.00, NOW(), NOW()),
('user7',  'u7@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000007', 'Sylhet', 'I am user7', 'user', 0, 0.00, NOW(), NOW()),
('user8',  'u8@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000008', 'Khulna', 'I am user8', 'user', 0, 0.00, NOW(), NOW()),
('user9',  'u9@gmail.com',  '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000009', 'Rajshahi', 'I am user9', 'user', 0, 0.00, NOW(), NOW()),
('user10', 'u10@gmail.com', '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000010', 'Barishal', 'I am user10', 'user', 0, 0.00, NOW(), NOW()),
('user11', 'u11@gmail.com', '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000011', 'Rangpur', 'I am user11', 'user', 0, 0.00, NOW(), NOW()),
('user12', 'u12@gmail.com', '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000012', 'Mymensingh', 'I am user12', 'user', 0, 0.00, NOW(), NOW()),
('user13', 'u13@gmail.com', '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000013', 'Comilla', 'I am user13', 'user', 0, 0.00, NOW(), NOW()),
('user14', 'u14@gmail.com', '$2y$12$Qr4NERgAEtxPuA8N96rEbu3iS0Lgm4/e.7kWp3NuwenmiFy2JVR8a', '01710000014', 'Gazipur', 'I am user14', 'user', 0, 0.00, NOW(), NOW());


INSERT INTO books (
    title,
    author,
    isbn,
    genre,
    description,
    `condition`,
    rental_price_per_day,
    security_deposit,
    lender_id,
    image_path,
    status,
    created_at,
    updated_at
) VALUES
('The Great Gatsby', 'F. Scott Fitzgerald', '9780743273565', 'Fiction', 'Classic novel set in the Jazz Age.', 'good', 2.50, 10.00, 1, 'books/gatsby.jpg', 'available', NOW(), NOW()),
('To Kill a Mockingbird', 'Harper Lee', '9780060935467', 'Fiction', 'Pulitzer Prize-winning novel about racial injustice.', 'fair', 2.00, 12.00, 2, 'books/mockingbird.jpg', 'available', NOW(), NOW()),
('1984', 'George Orwell', '9780451524935', 'Science Fiction', 'Dystopian novel about a totalitarian regime.', 'new', 3.00, 15.00, 3, 'books/1984.jpg', 'available', NOW(), NOW()),
('Pride and Prejudice', 'Jane Austen', '9780141439518', 'Romance', 'Classic romance novel set in England.', 'good', 2.20, 10.00, 4, 'books/pride.jpg', 'available', NOW(), NOW()),
('The Hobbit', 'J.R.R. Tolkien', '9780547928227', 'Fantasy', 'A fantasy adventure of Bilbo Baggins.', 'new', 3.50, 20.00, 5, 'books/hobbit.jpg', 'available', NOW(), NOW()),
('Moby-Dick', 'Herman Melville', '9781503280786', 'Fiction', 'Epic tale of the whaling ship Pequod.', 'fair', 1.80, 8.00, 6, 'books/mobydick.jpg', 'available', NOW(), NOW()),
('War and Peace', 'Leo Tolstoy', '9781853260629', 'Fiction', 'Classic historical novel set in Russia.', 'good', 3.00, 18.00, 7, 'books/warpeace.jpg', 'available', NOW(), NOW()),
('Hamlet', 'William Shakespeare', '9780743477123', 'Other', 'Shakespearean tragedy.', 'new', 1.50, 8.00, 8, 'books/hamlet.jpg', 'available', NOW(), NOW()),
('The Catcher in the Rye', 'J.D. Salinger', '9780316769488', 'Fiction', 'Story of teenage angst and rebellion.', 'good', 2.20, 10.00, 9, 'books/catcher.jpg', 'available', NOW(), NOW()),
('Brave New World', 'Aldous Huxley', '9780060850524', 'Science Fiction', 'Dystopian novel exploring futuristic society.', 'fair', 2.50, 12.00, 10, 'books/bravenewworld.jpg', 'available', NOW(), NOW()),
('Jane Eyre', 'Charlotte Bronte', '9780142437209', 'Romance', 'Gothic romance and coming-of-age novel.', 'good', 2.80, 14.00, 11, 'books/janeeyre.jpg', 'available', NOW(), NOW()),
('The Odyssey', 'Homer', '9780140268867', 'Fiction', 'Epic Greek poem of Odysseus.', 'new', 2.00, 10.00, 12, 'books/odyssey.jpg', 'available', NOW(), NOW()),
('Frankenstein', 'Mary Shelley', '9780486282114', 'Science Fiction', 'Classic tale of man-made monster.', 'good', 2.50, 12.00, 13, 'books/frankenstein.jpg', 'available', NOW(), NOW()),
('Wuthering Heights', 'Emily Bronte', '9780141439556', 'Romance', 'Gothic tale of love and revenge.', 'fair', 2.20, 10.00, 14, 'books/wuthering.jpg', 'available', NOW(), NOW()),
('The Lord of the Rings', 'J.R.R. Tolkien', '9780618640157', 'Fantasy', 'Epic trilogy of Middle-earth adventures.', 'new', 4.00, 25.00, 1, 'books/lotr.jpg', 'available', NOW(), NOW()),
('Crime and Punishment', 'Fyodor Dostoevsky', '9780143058144', 'Fiction', 'Psychological novel of guilt and redemption.', 'good', 2.80, 15.00, 2, 'books/crimepunishment.jpg', 'available', NOW(), NOW()),
('Anna Karenina', 'Leo Tolstoy', '9780143035008', 'Romance', 'Tragic love story in Imperial Russia.', 'fair', 2.50, 12.00, 3, 'books/annakarenina.jpg', 'available', NOW(), NOW()),
('The Divine Comedy', 'Dante Alighieri', '9780140448955', 'Other', 'Epic poem of the afterlife.', 'new', 3.50, 18.00, 4, 'books/divinecomedy.jpg', 'available', NOW(), NOW()),
('Dracula', 'Bram Stoker', '9780141439846', 'Fantasy', 'Classic vampire horror novel.', 'good', 2.20, 12.00, 5, 'books/dracula.jpg', 'available', NOW(), NOW()),
('Macbeth', 'William Shakespeare', '9780743477109', 'Other', 'Shakespearean tragedy.', 'fair', 1.80, 8.00, 6, 'books/macbeth.jpg', 'available', NOW(), NOW()),
('Great Expectations', 'Charles Dickens', '9780141439563', 'Fiction', 'Coming-of-age story of Pip.', 'good', 2.50, 12.00, 7, 'books/greatexpectations.jpg', 'available', NOW(), NOW()),
('Alice in Wonderland', 'Lewis Carroll', '9780141321073', 'Fantasy', 'Magical adventures of Alice.', 'new', 2.70, 15.00, 8, 'books/alice.jpg', 'available', NOW(), NOW()),
('The Iliad', 'Homer', '9780140275360', 'Fiction', 'Epic tale of the Trojan War.', 'good', 3.00, 15.00, 9, 'books/iliad.jpg', 'available', NOW(), NOW()),
('Les Misérables', 'Victor Hugo', '9780451419439', 'Fiction', 'Historical novel set in France.', 'fair', 3.00, 18.00, 10, 'books/lesmis.jpg', 'available', NOW(), NOW()),
('The Picture of Dorian Gray', 'Oscar Wilde', '9780141439570', 'Fiction', 'Novel about vanity and corruption.', 'new', 2.50, 12.00, 11, 'books/doriangray.jpg', 'available', NOW(), NOW()),
('The Alchemist', 'Paulo Coelho', '9780061122415', 'Fiction', 'Journey of self-discovery.', 'good', 2.20, 10.00, 12, 'books/alchemist.jpg', 'available', NOW(), NOW()),
('Meditations', 'Marcus Aurelius', '9780812968255', 'Other', 'Philosophical writings of Roman Emperor.', 'fair', 2.00, 8.00, 13, 'books/meditations.jpg', 'available', NOW(), NOW()),
('The Kite Runner', 'Khaled Hosseini', '9781594631931', 'Fiction', 'Story of friendship and redemption.', 'new', 2.80, 12.00, 14, 'books/kiterunner.jpg', 'available', NOW(), NOW());

