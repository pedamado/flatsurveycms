# README.md

# Flat Survey - A Lightweight Survey System

Flat Survey is a simple, file-based survey system built with PHP, HTML, CSS, and JavaScript. It allows editors to create surveys via CSV files and deploy them on any PHP-enabled server without databases or complex configurations.

## 🚀 Features

- **No Database Required**: Uses flat CSV files for both survey structure and data collection
- **Easy Survey Creation**: Define surveys through simple CSV files
- **Multiple Question Types**: Supports text inputs, checkboxes, radio buttons, and rating scales
- **Mobile-First Design**: Responsive layout optimized for all devices
- **Simple Deployment**: Just upload files via FTP to any PHP server
- **Real-time Results**: Built-in results visualization with charts
- **Submission Confirmation**: Configurable confirmation messages

## 📋 Quick Start

1. **Upload files** to your PHP server:
   - `index.php` - Main survey page
   - `results.php` - Results viewer
   - `survey.csv` - Survey configuration (see template)
   - `data.csv` - Will be created automatically (ensure writable permissions)

2. **Create your survey** by editing `survey.csv` using the CSV format.

3. **Access the survey**:
   - Survey form: `https://yourdomain.com/survey/`
   - Results page: `https://yourdomain.com/survey/results.php`

## 📝 Survey CSV Format

The `survey.csv` file uses this structure:

| TYPE        | CONTENT         | REQUIRED | NO ANSWER | BEFORE    | AFTER     | MIN  | MAX  |
|-------------|-----------------|----------|-----------|-----------|-----------|------|------|
| Title       | Survey Title    |          |           |           |           |      |      |
| Description | Description text|          |           |           |           |      |      |
| Separator   |                 |          |           |           |           |      |      |
| Question    | Question text   |          |           |           |           |      |      |
| Answer      | Text            | Yes/No   | Yes/No    |           |           |      |      |
| confirm     | Confirmation msg|          |           |           |           |      |      |
| Submit      | Submit Text     |          |           |           |           |      |      |

### Answer Types:
- `Text`: Simple text input
- `Checkbox`: Single checkbox
- `Two-Options`: Two radio buttons
- `X-Option-Scale`: Rating scale (Three, Four, Five, Seven, etc.)
  - Use MIN/MAX for custom ranges (e.g., -2 to +2)
  - BEFORE/AFTER for scale labels

## 🎨 Customization

### Styling
Modify the CSS in `index.php` to match your brand:
- Colors: Update `#00f` (blue) to your preferred color
- Fonts: Change the `font-family` property
- Layout: Adjust container widths and spacing

### Survey Configuration
All survey customization is done through `survey.csv`:
- Add/remove questions
- Change answer types
- Set required fields
- Customize confirmation messages

## 📊 Results

The `results.php` page displays:
- Question-by-question statistics
- Answer distributions
- Percentage visualizations
- Total response counts

Results are automatically updated after each submission.

## 🔒 Permissions

Ensure the server has write permissions for:
- `data.csv` (stores responses)
- Directory containing CSV files

## 🛠️ Technical Details

- **Requirements**: PHP 7.4+, writable directory
- **No external dependencies**
- **File Structure**:
  ```
  survey/
  ├── index.php      # Main survey page
  ├── results.php    # Results viewer
  ├── survey.csv     # Survey configuration
  └── data.csv       # Response data (auto-created)
  ```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 📄 License

MIT License - see LICENSE file for details

## 🆘 Support

Issues and feature requests can be submitted via:
- GitHub Issues
- Documentation updates via Pull Requests

---

*Simple surveys without the complexity.*

