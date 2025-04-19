<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Announcement;
use App\Models\AnnouncementEmployee;

class DeleteAnnouncement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:announcement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It deletes 1 year old announcement.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fetching old announcments...');
        $announcements = Announcement::whereYear('created_at', '<', now());
        if ($announcements->count() > 0) {
            foreach ($announcements->get() as $announcement) {
                AnnouncementEmployee::where('announcement_id', $announcement->id)->delete();
                $announcement->delete();
            }
            $this->info('All old announcments deleted successfully.');
        } else {
            $this->info('There are no old announcments.');
        }
    }
}
