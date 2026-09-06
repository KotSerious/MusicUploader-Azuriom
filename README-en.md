<div align="right">
  <a href="README.md">Русский</a> | <a href="README-en.md">English</a>
</div>


# 🎵 Music Uploader plugin for Azuriom

A user-friendly plugin for CMS **Azuriom v1.2+** that allows your server players to upload their own music tracks directly via the user dashboard. An excellent solution for integration with in-game radio stations, voice chats (Voice Chat), or jukeboxes in Minecraft.

---

## ✨ Features

- 🔒 **Role Permissions:** Upload access can be granted to specific roles/groups (e.g., VIP, Premium) via the Azuriom admin panel.
- 🎛️ **Built-in HTML5 Player:** Ability to preview and listen to uploaded tracks directly on the website without downloading.
- 📋 **One-click Copying:** A convenient button for instant copying of the direct audio file link to paste it into the game.
- 🛠️ **Moderator Panel:** A dedicated admin dashboard to view and delete music files.
- 🌐 **Multilingual Support:** Full support for both Russian (`ru`) and English (`en`) languages.

---

## 📸 Screenshots

| User Dashboard | Admin Panel |
| :---: | :---: |
| ![User Dashboard](https://i.imgur.com/gkPEsd5.png) | ![Admin Panel](https://i.imgur.com/xti6frA.png) |

---

## 🚀 Installation

### Step 1. Uploading Files
Unpack the plugin archive into your website directory at the following path:
```bash
/var/www/azuriom/plugins/musicuploader
```
> ⚠️ **Important:** The folder name must be strictly in lowercase: `musicuploader`.

### Step 2. Enabling the Plugin
1. Go to **Azuriom Admin Panel** ➔ **Plugins**.
2. Find **Music Uploader** in the list and click **Enable**.

### Step 3. Web Server Configuration (Recommended)
Since music files can be large, make sure to set sufficient limits in your `php.ini`:
```ini
upload_max_filesize = 64M
post_max_size = 64M
memory_limit = 256M
```
_After changing the settings, restart your web server (Apache/PHP-FPM)._

---

## ⚙️ Permissions Setup

1. Go to **Admin Panel** ➔ **Users** ➔ **Roles**.
2. Edit the group you want to grant music access to.
3. Check the box next to the permission: `Загрузка музыки` (Music Upload).

---

## 📁 File Structure

```text
plugins/musicuploader/
├── plugin.json                 # Plugin configuration for Azuriom
├── composer.json               # Namespace autoloading (PSR-4)
├── routes/
│   └── web.php                 # Unified routes (User & Admin)
├── src/
│   ├── Controllers/
│   │   ├── MusicController.php # User logic (Upload/Delete)
│   │   └── Admin/
│   │       └── AdminController.php # Admin logic (Moderation)
│   ├── Models/
│   │   └── MusicTrack.php      # Track database model
│   └── Providers/
│       └── MusicUploaderServiceProvider.php # Plugin service provider
└── resources/
    ├── lang/                   # Language packets (ru/en)
    └── views/                  # UI (Blade templates)
```
