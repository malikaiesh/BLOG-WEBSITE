<?php
class Settings {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $settings = $this->db->fetchAll("SELECT * FROM site_settings");
        $formatted = [];
        foreach ($settings as $s) {
            if ($s['key'] === 'footer_social_links') {
                $formatted[$s['key']] = json_decode($s['value'], true);
            } else {
                $formatted[$s['key']] = $s['value'];
            }
        }
        return $formatted;
    }

    public function update($data) {
        foreach ($data as $key => $value) {
            if ($key === 'footer_social_links') {
                $value = json_encode($value);
            }
            $this->db->query("UPDATE site_settings SET value = :value, updated_at = NOW() WHERE key = :key", [
                ':key' => $key,
                ':value' => $value
            ]);
        }
        return true;
    }
}