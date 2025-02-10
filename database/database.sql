-- Table des utilisateurs
CREATE TABLE users (
    id_user SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) CHECK (role IN ('admin', 'teacher', 'student')) NOT NULL,
    status VARCHAR(10) CHECK (status IN ('pending', 'active', 'suspended')) DEFAULT 'pending'
);

-- Table des catégories de cours
CREATE TABLE categories (
    id_categories SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

-- Table des tags
CREATE TABLE tags (
    id_tags SERIAL PRIMARY KEY,
    name VARCHAR(30) NOT NULL UNIQUE
);

-- Table des cours
CREATE TABLE courses (
    id_courses SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    content_type VARCHAR(10) CHECK (content_type IN ('video', 'document')) NOT NULL,
    content_url VARCHAR(255) NOT NULL,
    teacher_id INT NOT NULL,
    category_id INT NOT NULL,
    status VARCHAR(10) CHECK (status IN ('draft', 'published', 'archived')) DEFAULT 'published',
    CONSTRAINT fk_teacher FOREIGN KEY (teacher_id) REFERENCES users(id_user) ON DELETE CASCADE,
    CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories(id_categories) ON DELETE RESTRICT
);

-- Table de relation entre cours et tags (Many-to-Many)
CREATE TABLE course_tags (
    course_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (course_id, tag_id),
    CONSTRAINT fk_course FOREIGN KEY (course_id) REFERENCES courses(id_courses) ON DELETE CASCADE,
    CONSTRAINT fk_tag FOREIGN KEY (tag_id) REFERENCES tags(id_tags) ON DELETE CASCADE
);

-- Table des inscriptions aux cours
CREATE TABLE enrollments (
    id SERIAL PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(10) CHECK (status IN ('active', 'completed', 'dropped')) DEFAULT 'active',
    CONSTRAINT fk_student FOREIGN KEY (student_id) REFERENCES users(id_user) ON DELETE CASCADE,
    CONSTRAINT fk_course_enrollment FOREIGN KEY (course_id) REFERENCES courses(id_courses) ON DELETE CASCADE,
    CONSTRAINT unique_enrollment UNIQUE (student_id, course_id)
);
