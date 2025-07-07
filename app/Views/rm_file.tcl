#!/usr/bin/env tclsh
# remove_backup_files.tcl
#
# Usage:
#   tclsh remove_backup_files.tcl  TARGET_DIR  ?EXTENSION?  ?-f?
#
# Examples:
#   tclsh remove_backup_files.tcl  Views
#   tclsh remove_backup_files.tcl  Views .tmp
#   tclsh remove_backup_files.tcl  Views .orig -f

# ── Parse Arguments ─────────────────────────────────────────────
if {[llength $argv] < 1} {
    puts stderr "Usage: tclsh $argv0 TARGET_DIR ?EXTENSION? ?-f?"
    exit 1
}

set targetDir  [lindex $argv 0]
set extension  [lindex $argv 1]
set forceFlag  0

# Handle optional args
if {[string match -* $extension]} {
    set forceFlag 1
    set extension ".bak"
} elseif {[llength $argv] >= 3 && [lindex $argv 2] eq "-f"} {
    set forceFlag 1
}

if {$extension eq ""} {
    set extension ".bak"
}

# ── Validate ────────────────────────────────────────────────────
if {![file isdirectory $targetDir]} {
    puts stderr "❌ '$targetDir' is not a directory."
    exit 1
}

puts "🔍 Looking for *$extension files in $targetDir ..."

# ── File Collection ─────────────────────────────────────────────
proc collectBackupFiles {dir ext} {
    set list {}
    foreach item [glob -nocomplain -directory $dir *] {
        if {[file isdirectory $item]} {
            set list [concat $list [collectBackupFiles $item $ext]]
        } elseif {[string match "*$ext" $item]} {
            lappend list $item
        }
    }
    return $list
}

set bakFiles [collectBackupFiles $targetDir $extension]

if {[llength $bakFiles] == 0} {
    puts "✅ No files with extension $extension found."
    exit 0
}

# ── Prompt (if not -f) ──────────────────────────────────────────
puts "🧾 Found [llength $bakFiles] files ending with '$extension'"
if {!$forceFlag} {
    puts -nonewline "Delete them all? (y/N) "
    flush stdout
    gets stdin reply
    if {[string tolower $reply] ne "y"} {
        puts "❌ Aborted."
        exit 0
    }
}

# ── Deletion ───────────────────────────────────────────────────
set count 0
foreach f $bakFiles {
    catch {
        file delete -force -- $f
        incr count
    }
}
puts "🗑️  Deleted $count file(s) with extension '$extension'."
