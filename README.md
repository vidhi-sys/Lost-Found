# VIT Bhopal Lost & Found System

A simple and efficient web-based Lost & Found system for VIT Bhopal students to report and find lost items on campus.

![PHP](https://img.shields.io/badge/PHP-8.0+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.0+-purple.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📋 Table of Contents

- [Features](#-features)
- [Demo](#-demo)
- [Installation](#-installation)
- [Usage](#-usage)
- [Database Schema](#-database-schema)
- [File Structure](#-file-structure)
- [API Endpoints](#-api-endpoints)
- [Contributing](#-contributing)
- [License](#-license)
- [Support](#-support)

## ✨ Features

- **🔍 Easy Reporting**: Simple form to report lost or found items
- **📍 Location-based**: Track items by campus locations
- **📱 Responsive Design**: Works on all devices
- **🕒 Real-time Updates**: Automatically displays latest submissions
- **📧 Contact Integration**: Built-in contact information sharing
- **🎯 Smart Categorization**: Automatic classification as Lost/Found
- **⚡ Fast & Lightweight**: Optimized for quick campus use

## 🚀 Demo

<img width="1519" height="841" alt="image" src="https://github.com/user-attachments/assets/2a085172-48ed-4f53-bb56-6dedf2563a61" />


## 🛠 Installation

### Prerequisites

- Web server (Apache/Nginx)
- PHP 8.0 or higher
- MySQL 5.7 or higher
- phpMyAdmin (recommended)

### Step-by-Step Setup

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/vit-lost-found.git
   cd vit-lost-found
   ```

2. **Database Setup**
   - Open phpMyAdmin (`http://localhost/phpmyadmin`)
   - Create a new database: `vit_lost_found`
   - Import the SQL schema:
   ```sql
   CREATE TABLE items (
       id INT PRIMARY KEY AUTO_INCREMENT,
       item_type ENUM('lost', 'found') NOT NULL,
       item_name VARCHAR(255) NOT NULL,
       location VARCHAR(255) NOT NULL,
       description TEXT NOT NULL,
       contact_info VARCHAR(255),
       reported_at DATETIME DEFAULT CURRENT_TIMESTAMP,
       status ENUM('active', 'resolved') DEFAULT 'active'
   );
   ```

3. **Configuration**
   - Update `config.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'vit_lost_found');
   ```

4. **File Placement**
   - Place all files in your web server's root directory
   - For XAMPP: `C:\xampp\htdocs\lost-found\`
   - For WAMP: `C:\wamp64\www\lost-found\`

5. **Access the Application**
   - Open your browser and navigate to:
   ```
   http://localhost/lost-found/index.php
   ```

## 📖 Usage

### For Students

1. **Reporting a Lost Item**
   - Select "I Lost Something"
   - Enter item details and last known location
   - Provide contact information
   - Submit the report

2. **Reporting a Found Item**
   - Select "I Found Something"
   - Describe the found item and location
   - Provide your contact details
   - Submit to help return the item

3. **Finding Items**
   - Browse the recent items list
   - Contact the reporter if you find your item
   - Mark items as resolved when recovered

### For Administrators

- Monitor all reported items via phpMyAdmin
- Manage database and user submissions
- Resolve outdated or completed cases

## 🗃 Database Schema

### Items Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT AUTO_INCREMENT | Unique item identifier |
| `item_type` | ENUM('lost','found') | Type of report |
| `item_name` | VARCHAR(255) | Name/Title of the item |
| `location` | VARCHAR(255) | Campus location |
| `description` | TEXT | Detailed description |
| `contact_info` | VARCHAR(255) | Contact details |
| `reported_at` | DATETIME | Timestamp of report |
| `status` | ENUM('active','resolved') | Current status |

### Sample Data

```sql
INSERT INTO items (item_type, item_name, location, description, contact_info) VALUES
('lost', 'iPhone 13 Pro', 'AB1 Block, Room 205', 'Black iPhone with transparent case', 'student@vitbhopal.ac.in'),
('found', 'Engineering Notebook', 'Library, 2nd Floor', 'Blue notebook with physics notes', 'finder@vitbhopal.ac.in');
```

## 📁 File Structure

```
vit-lost-found/
│
├── index.php              # Main application file
├── config.php             # Database configuration
├── submit_item.php        # Form submission handler
├── get_items.php          # API endpoint for items (optional)
├── README.md              # Project documentation
└── assets/                # Static assets (optional)
    ├── css/
    ├── js/
    └── images/
```

## 🔌 API Endpoints

### GET /get_items.php
Returns all active items in JSON format.

**Response:**
```json
{
    "success": true,
    "items": [
        {
            "id": 1,
            "item_type": "lost",
            "item_name": "iPhone 13 Pro",
            "location": "AB1 Block",
            "description": "Black iPhone with case",
            "contact_info": "student@vitbhopal.ac.in",
            "reported_at": "2023-10-15 09:30:00",
            "status": "active"
        }
    ]
}
```

### POST /submit_item.php
Accepts form data to create new lost/found reports.

**Parameters:**
- `itemType` (required): 'lost' or 'found'
- `itemName` (required): Name of the item
- `location` (required): Location on campus
- `description` (required): Item description
- `contactInfo` (optional): Contact information

## 🤝 Contributing

We welcome contributions from VIT Bhopal students and developers!

### How to Contribute

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Setup

```bash
# Clone the repository
git clone https://github.com/your-username/vit-lost-found.git

# Set up local development environment
# Make sure XAMPP/WAMP is running
# Configure database connection
# Start coding!
```

### Suggested Improvements

- [ ] Add user authentication
- [ ] Implement image upload functionality
- [ ] Add email notifications
- [ ] Create admin dashboard
- [ ] Add search and filter features
- [ ] Implement QR code integration

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

### For Technical Issues

1. **Check the logs**: Look for PHP error logs in your server directory
2. **Verify database connection**: Ensure MySQL is running and credentials are correct
3. **Check file permissions**: Ensure PHP files have proper read/write permissions

### Common Problems & Solutions

**Database Connection Failed**
- Verify MySQL service is running
- Check database credentials in `config.php`
- Ensure database `vit_lost_found` exists

**Form Not Submitting**
- Check if all required fields are filled
- Verify PHP is properly installed and configured
- Check web server error logs

### Getting Help

- 📧 Email: [ vidhiudasi2@gmail.com]
- 🐛 [Open an Issue](https://github.com/vidhi-sys/Lost&Found/issues)
- 💬 Discussion: [GitHub Discussions]

## 🙏 Acknowledgments

- VIT Bhopal Administration for support
- Contributors and testers from the student community
- Open source libraries and tools used in this project

---

<div align="center">

**Made with ❤️ for VIT Bhopal Community**

*Helping students reunite with their lost belongings*

[Report Bug](https://github.com/vidhi-sys/Lost&Found/issues) • [Request Feature](https://github.com/vidhi-sys/Lost&Found/issues)

</div>

## 📞 Contact

**Project Maintainer**: vidhi udasi  
**Email**: vidhiudasi2@gmail.com  
**VIT Bhopal**: [www.vitbhopal.ac.in](https://www.vitbhopal.ac.in)

---

*If you found this project helpful, please give it a ⭐ on GitHub!*
