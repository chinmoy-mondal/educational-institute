#!/usr/bin/env tclsh
# replace_in_all_files.tcl
#
# Usage (directory):
#   tclsh replace_in_all_files.tcl  DIR   SEARCH_TEXT   REPLACE_TEXT
# Example:
#   tclsh replace_in_all_files.tcl  Views mom           mother
#
# Usage (single file):
#   tclsh replace_in_all_files.tcl  path/to/file.php  mom  mother

# ─── Parse command-line arguments ───────────────────────────────────────────
if {[llength $argv] < 3} {
    puts stderr "Usage:  tclsh $argv0 PATH SEARCH_TEXT REPLACE_TEXT"
    exit 1
}
set rootPath    [lindex $argv 0]   ;# file or directory
set searchText  [lindex $argv 1]   ;# literal search string
set replaceText [lindex $argv 2]   ;# literal replacement string

# Restrict to certain extensions when walking a *directory*.
# Empty list ⇒ all extensions are allowed.
set fileExtensions {.php}

# Backup settings
set makeBackup  true
set backupExt   ".bak"

# ─── Helpers ────────────────────────────────────────────────────────────────
proc processFile {path searchText replaceText makeBackup backupExt} {
    if {![file readable $path]} {
        puts stderr "⚠️  Skipping unreadable file: $path"
        return
    }
    set in   [open $path r];  set data [read $in];  close $in

    if {[string first $searchText $data] != -1} {
        set newData [string map [list $searchText $replaceText] $data]

        if {$makeBackup} {
            catch {file copy -force -- $path "${path}${backupExt}"}
        }

        set out [open $path w]
        puts -nonewline $out $newData
        close $out
        puts "✓ Updated: $path"
    }
}

proc walkDir {dir fileExts searchText replaceText makeBackup backupExt} {
    foreach item [glob -nocomplain -directory $dir *] {
        if {[file isdirectory $item]} {
            walkDir $item $fileExts $searchText $replaceText $makeBackup $backupExt
        } else {
            if {![llength $fileExts] || [file extension $item] in $fileExts} {
                processFile $item $searchText $replaceText $makeBackup $backupExt
            }
        }
    }
}

# ─── Run ────────────────────────────────────────────────────────────────────
puts "🔍 Replacing '$searchText' → '$replaceText' in: $rootPath"
if {[file isfile $rootPath]} {
    processFile $rootPath $searchText $replaceText $makeBackup $backupExt
} elseif {[file isdirectory $rootPath]} {
    walkDir $rootPath $fileExtensions $searchText $replaceText $makeBackup $backupExt
} else {
    puts stderr "❌ Error: '$rootPath' is not a file or directory"
    exit 1
}
puts "✅ Done."
