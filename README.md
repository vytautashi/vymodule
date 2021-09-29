# vymodule
Simple module for *PrestaShop*.

This module does not have any real life use. It was made in mind to gain basic knowledge of developing *PrestaShop* module.

**Module contains:**
- Configuration window with savable form values
- Custom DB table creation during installation and data seeder
- Action hook (adds suffix at the end of product name after its creation)
- Admin controller, module tab
  - Displays list of custom table records
  - Add/Edit/Remove record

## Getting Started

### Prerequisites
- [PrestaShop](https://github.com/PrestaShop/PrestaShop/releases) (tested on 1.7.7.8 version)

### Installation
**Get module:** (using one of method)
- By downloading [latest release](../../releases/latest/) `vymodule.zip` file to your computer and uploading it via *PrestaShop* admin panel graphical user interface (GUI).
- (For development) By cloning repository to your *PrestaShop* `/modules/` directory using command:
```
git clone https://github.com/vytautashi/vymodule.git
```