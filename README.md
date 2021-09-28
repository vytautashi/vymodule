# vymodule
Simple module for *PrestaShop*.

This module does not have any real life use. It was made in mind to gain basic knowledge of developing *PrestaShop* module.

**Module contains:**
- Configuration window with savable form values
- Custom DB table creation during installation
  - Data Seeder
- Admin controller, module tab
  - Displays list of custom table records
  - **(TODO)** Add/Edit record
- Action hook (adds suffix at the end of product name after its creation)

## Getting Started

### Prerequisites
- [PrestaShop](https://github.com/PrestaShop/PrestaShop/releases) (tested on 1.7.7.8)

### Installation
**Get module:** (using one of method)
- By cloning repository to your *PrestaShop* `/modules/` directory using command `git clone https://github.com/vytautashi/vymodule.git`
- By downloading [latest release](../../releases/latest/) to your computer and uploading it via *PrestaShop* admin panel GUI.