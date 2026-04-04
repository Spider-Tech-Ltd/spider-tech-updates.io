-- ============================================================
-- Migration: Add avatar column to members table
-- Date:      2026-04-04
-- Purpose:   Stores the file path to a member's uploaded
--            profile picture (e.g. /uploads/forum/avatars/avatar_1_xxx.jpg)
-- ============================================================

ALTER TABLE `members`
  ADD COLUMN `avatar` VARCHAR(500) NULL DEFAULT NULL
    COMMENT 'Relative path to member profile picture'
  AFTER `name`;
