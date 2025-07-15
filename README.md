# 🏫 Automatic Timetable Generation System

A web-based **Teacher and Class Timetable Generator** designed for schools and colleges. The system automates the generation of class-wise and teacher-wise timetables, allowing staff to efficiently manage schedules.

---

## 📌 Project Overview

This project allows admin or teachers to:

- Register and log in securely.
- Add teachers, subjects, and classes.
- Automatically generate timetables.
- View class-wise and teacher-wise timetables.
- Download timetables in CSV format.

Timetables are generated dynamically and stored in the MySQL database. The frontend provides an easy-to-use interface for interacting with the system.

---

## 🛠️ Technologies Used

| Layer    | Technology            |
| -------- | --------------------- |
| Frontend | HTML, CSS, JavaScript |
| Backend  | PHP                   |
| Database | MySQL                 |

---

## 🎨 Key Features

- 📋 **Teacher Registration & Login System**\
  Secure authentication using email and password, with role selection (Admin or Teacher).

- 🧑‍🏫 **Add Data Interface**\
  Teachers and subjects can be added with ease via the data entry form.

- 🛠️ **Automatic Timetable Generation**\
  One-click timetable generation for classes, minimizing manual effort.

- 📊 **Class-wise and Teacher-wise Views**\
  Separate views for class-wise and teacher-wise timetables.

- 📥 **CSV Timetable Download**\
  Download generated timetables directly as CSV files.

- 🔐 **Role-Based Access Control**\
  Users can only access permitted functionalities after logging in.

---

## 📸 Screenshots

Place your project screenshots in a `screenshots/` folder and reference them below:

```markdown
- **Login & Signup System:**  
  ![Login & Signup](screenshots/signup_login.png)

- **Data Entry & Generation Interface:**  
  ![Data Entry Page](screenshots/add_data_generate.png)

- **Class-wise Timetable Display:**  
  ![Class-wise Timetable](screenshots/classwise_timetable.png)
```

*(Note: Replace above links with your actual screenshot file paths.)*

---

## 📂 Setup Instructions

1. **Clone or Download Repository**

   ```bash
   git clone https://github.com/yourusername/automatic-timetable-generator.git
   ```

2. **Database Setup**

   - Create a new MySQL database (e.g., `timetable_system`).
   - Import the provided SQL schema:

   ```sql
   SOURCE database.sql;
   ```

3. \*\*Configure Database in \*\*\`\`

   ```php
   $host = 'localhost';
   $user = 'root';    // your MySQL username
   $password = '';    // your MySQL password
   $database = 'timetable_system';
   ```

4. **Running the System**

   - Place the project folder inside your XAMPP/WAMP/LAMP `htdocs` directory.
   - Start Apache and MySQL.
   - Access via:

   ```
   http://localhost/your-project-folder/
   ```

---

## 🚀 How to Use

1. **Sign Up / Login**\
   Create an account or log in using existing credentials.

2. **Add Teachers and Subjects**\
   Use the form to enter teacher names, subjects, and class details.

3. **Generate Timetable**\
   Click **Generate Timetable** to auto-generate class schedules.

4. **View Timetables**\
   Choose between class-wise or teacher-wise views.

5. **Download Timetable (CSV)**\
   Export any timetable as a CSV file using the download button.

---

## 📈 Future Improvements

- PDF and Excel export functionality.
- Teacher availability management.
- Timetable conflict detection.
- Responsive design enhancements.

---

## 📧 Contact

For questions or issues, feel free to open an issue or contact at [**galipranay123@gmail.com**](mailto\:galipranay123@gmail.com).

