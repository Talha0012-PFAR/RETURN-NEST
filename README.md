# Lost & Found Management System

A comprehensive PHP and MySQL-based web application for managing lost and found items. This system provides a user-friendly interface for reporting lost items, submitting found items, and connecting people with their belongings.

## Features

### User Features
- **User Registration & Authentication**: Secure login/registration with password hashing
- **Report Lost Items**: Submit detailed information about lost items with images
- **Report Found Items**: Submit found items with descriptions and photos
- **Search & Browse**: Search through lost and found items with filters
- **Contact Owners/Finders**: Direct communication through email links
- **Similar Items Suggestions**: AI-powered matching suggestions

### Admin Features
- **Admin Dashboard**: Overview with statistics and quick actions
- **User Management**: View, edit, delete users and manage roles
- **Item Moderation**: Approve, reject, or delete submitted items
- **Reports Generation**: Generate statistics and reports
- **Content Management**: Manage all lost and found items

### Technical Features
- **Responsive Design**: Mobile-friendly Bootstrap-based interface
- **Image Upload**: Secure image upload with validation
- **Search & Filtering**: Advanced search with pagination
- **Security**: SQL injection prevention, XSS protection, CSRF tokens
- **Session Management**: Secure user sessions

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (optional)

### Setup Instructions

1. **Clone or Download the Project**
   ```bash
   git clone https://github.com/yourusername/lost-found-system.git
   cd lost-found-system
   ```

2. **Database Setup**
   - Create a MySQL database named `lost_found_db`
   - Import the database schema:
   ```bash
   mysql -u root -p lost_found_db < database.sql
   ```

3. **Configuration**
   - Edit `includes/config.php` and update database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'lost_found_db');
   ```

4. **File Permissions**
   - Ensure the `uploads/` directory is writable:
   ```bash
   chmod 755 uploads/
   ```

5. **Web Server Configuration**
   - Point your web server to the project directory
   - Ensure PHP has write permissions to the uploads folder

### Default Login Credentials

**Admin User:**
- Username: `admin`
- Password: `admin123`

**Sample Users:**
- Email: `john@example.com` / Password: `user123`
- Email: `jane@example.com` / Password: `user123`

## Project Structure

```
lost-found-system/
├── admin/                 # Admin panel files
│   ├── dashboard.php      # Admin dashboard
│   ├── users.php         # User management
│   ├── lost-items.php    # Lost items management
│   ├── found-items.php   # Found items management
│   └── reports.php       # Reports generation
├── auth/                 # Authentication files
│   ├── login.php         # User login
│   ├── register.php      # User registration
│   └── logout.php        # User logout
├── includes/             # Core files
│   ├── config.php        # Database configuration
│   ├── header.php        # Page header
│   └── footer.php        # Page footer
├── modules/              # Feature modules
│   ├── lost/            # Lost items module
│   │   ├── add.php      # Add lost item
│   │   ├── list.php     # List lost items
│   │   └── view.php     # View lost item
│   └── found/           # Found items module
│       ├── add.php      # Add found item
│       ├── list.php     # List found items
│       └── view.php     # View found item
├── assets/              # Static assets
│   ├── css/            # Stylesheets
│   │   └── style.css   # Custom CSS
│   └── js/             # JavaScript files
│       └── script.js   # Custom JavaScript
├── uploads/            # Uploaded images
├── database.sql        # Database schema
├── index.php          # Home page
└── README.md         # This file
```

## Database Schema

### Tables
- **users**: User accounts and profiles
- **admin**: Admin user accounts
- **lost_items**: Lost item reports
- **found_items**: Found item reports
- **matches**: Item matching records

### Key Fields
- User authentication with password hashing
- Item status tracking (pending, approved, rejected, found, claimed)
- Image upload support
- Timestamp tracking for all records

## Usage

### For Users
1. **Register/Login**: Create an account or login
2. **Report Items**: Submit lost or found items with details
3. **Search**: Browse through existing items
4. **Contact**: Reach out to item owners or finders

### For Administrators
1. **Login**: Use admin credentials
2. **Dashboard**: View system overview and statistics
3. **Moderate**: Review and approve/reject submitted items
4. **Manage Users**: Handle user accounts and permissions
5. **Generate Reports**: Create statistical reports

## Security Features

- **Password Hashing**: Uses PHP's `password_hash()` and `password_verify()`
- **SQL Injection Prevention**: Prepared statements throughout
- **XSS Protection**: Input sanitization and output escaping
- **Session Security**: Secure session management
- **File Upload Security**: Image validation and secure storage
- **Access Control**: Role-based access control

## Customization

### Styling
- Modify `assets/css/style.css` for custom styling
- Bootstrap 5 framework for responsive design
- Font Awesome icons for enhanced UI

### Functionality
- Extend modules in the `modules/` directory
- Add new admin features in the `admin/` directory
- Modify database schema as needed

### Configuration
- Update site settings in `includes/config.php`
- Modify upload settings and file size limits
- Adjust pagination and search parameters

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Verify database credentials in `config.php`
   - Ensure MySQL service is running
   - Check database exists and is accessible

2. **Image Upload Issues**
   - Verify `uploads/` directory permissions
   - Check PHP upload settings in `php.ini`
   - Ensure file size limits are appropriate

3. **Session Issues**
   - Check PHP session configuration
   - Verify session storage permissions
   - Clear browser cookies if needed

### Error Logs
- Check PHP error logs for detailed error messages
- Enable error reporting in development environment
- Monitor web server logs for issues

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:
- Create an issue on GitHub
- Contact: info@lostfound.com
- Documentation: [Wiki Link]

## Changelog

### Version 1.0.0
- Initial release
- User authentication system
- Lost and found item management
- Admin panel
- Responsive design
- Image upload functionality
- Search and filtering
- Security features

---

**Developed with ❤️ for helping people find their lost items**
