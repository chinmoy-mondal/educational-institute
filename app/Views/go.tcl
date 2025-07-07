#!/usr/bin/env tclsh
# replace_in_all_files.tcl
# Usage:
#   tclsh replace_in_all_files.tcl  ROOT_DIR  SEARCH_TEXT  REPLACE_TEXT
# Example:
#   tclsh replace_in_all_files.tcl  Views     mom          mother

# ─── Parse command-line arguments ──────────────────────────────────────────
if {[llength $argv] < 3} {
    puts stderr "Usage:  tclsh $argv0 ROOT_DIR SEARCH_TEXT REPLACE_TEXT"
    exit 1
}

set rootDir     [lindex $argv 0]
set searchText  [lindex $argv 1]
set replaceText [lindex $argv 2]

# (optional) restrict to certain extensions; empty list ⇒ all files
set fileExtensions {.php}

# make backups?
set makeBackup  true
set backupExt   ".bak"

# ─── File-processing helpers ───────────────────────────────────────────────
proc processFile {path searchText replaceText makeBackup backupExt} {
    set in  [open $path r]
    set data [read $in]
    close $in

    if {[string first $searchText $data] != -1} {
        set newData [string map [list $searchText $replaceText] $data]

        if {$makeBackup} {
            file copy -force -- $path "${path}${backupExt}"
        }
        set out [open $path w]
        puts -nonewline $out $newData
        close $out
        puts "✓ Updated: $path"
    }
}

proc walkDir {dir args} {
    foreach item [glob -nocomplain -directory $dir *] {
        if {[file isdirectory $item]} {
            walkDir $item {*}$args
        } else {
            lassign $args fileExts searchText replaceText makeBackup backupExt
            if {![llength $fileExts] || [file extension $item] in $fileExts} {
                processFile $item $searchText $replaceText $makeBackup $backupExt
            }
        }
    }
}

# ─── Run ───────────────────────────────────────────────────────────────────
puts "🔍 Replacing '$searchText' → '$replaceText' under $rootDir ..."
walkDir $rootDir $fileExtensions $searchText $replaceText $makeBackup $backupExt
puts "✅ Done."
