<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubjectPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'debugbar.enabled' => false,
            'database.default' => 'subject_testing',
            'database.connections.subject_testing' => [
                'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
            ],
        ]);
        Storage::fake('public');

        foreach (['subjects', 'grades'] as $table) {
            Schema::create($table, function (Blueprint $table) {
                $table->integer('id');
                $table->string('name');
                $table->string('status')->default('1');
            });
        }
        Schema::create('subjects_in_grades', function (Blueprint $table) {
            $table->integer('subject_id');
            $table->integer('grade_id');
        });
        Schema::create('chapters', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('subject_id');
            $table->integer('grade_id');
            $table->string('name');
            $table->string('number');
            $table->string('status')->default('1');
        });
        Schema::create('subject_lessons', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('chapter_id');
            $table->string('title');
            $table->string('body');
            $table->string('type');
            $table->softDeletes();
        });

        DB::table('subjects')->insert(['id' => 1, 'name' => 'Mathematics']);
        DB::table('grades')->insert([
            ['id' => 1, 'name' => 'Grade one'], ['id' => 2, 'name' => 'Grade two'],
        ]);
        DB::table('subjects_in_grades')->insert([
            ['subject_id' => 1, 'grade_id' => 1], ['subject_id' => 1, 'grade_id' => 2],
        ]);
    }

    public function test_chapters_are_unique_ordered_and_limited_to_the_requested_grade(): void
    {
        Storage::disk('public')->put('uploads/lesson.pdf', 'Test book');
        DB::table('chapters')->insert([
            ['id' => 11, 'subject_id' => 1, 'grade_id' => 1, 'name' => "Lesson's title", 'number' => '1_1_10', 'status' => '1'],
            ['id' => 12, 'subject_id' => 1, 'grade_id' => 2, 'name' => 'Other grade', 'number' => '1', 'status' => '1'],
            ['id' => 13, 'subject_id' => 1, 'grade_id' => 1, 'name' => 'Inactive lesson', 'number' => '3', 'status' => '0'],
            ['id' => 14, 'subject_id' => 1, 'grade_id' => 1, 'name' => 'Lesson without resources', 'number' => '1_1_2', 'status' => '1'],
        ]);
        DB::table('subject_lessons')->insert([
            ['id' => 1, 'chapter_id' => 11, 'title' => 'Old video', 'body' => 'https://youtu.be/abcdefghijk', 'type' => 'video', 'deleted_at' => null],
            ['id' => 2, 'chapter_id' => 11, 'title' => 'Current video', 'body' => 'https://youtu.be/12345678901', 'type' => 'video', 'deleted_at' => null],
            ['id' => 3, 'chapter_id' => 11, 'title' => 'Deleted video', 'body' => 'https://youtu.be/deleted0000', 'type' => 'video', 'deleted_at' => now()],
            ['id' => 4, 'chapter_id' => 11, 'title' => 'Book', 'body' => 'storage/uploads/lesson.pdf', 'type' => 'file', 'deleted_at' => null],
        ]);

        $response = $this->get($this->subjectUrl());
        $response->assertOk()->assertViewHas('subjectContents', function ($chapters) {
            return $chapters->pluck('chapter_id')->all() === [14, 11]
                && $chapters[1]->video_title === 'Current video'
                && $chapters[1]->video_body === 'https://youtu.be/12345678901'
                && $chapters[1]->book_url === asset('storage/uploads/lesson.pdf');
        });
        $response->assertDontSee('Other grade')->assertDontSee('Inactive lesson');
    }

    public function test_empty_subject_retains_its_heading_in_all_three_languages(): void
    {
        foreach (['en', 'da', 'pa'] as $language) {
            $response = $this->get($this->subjectUrl($language));
            $response->assertOk()->assertSee('Mathematics')->assertSee('Grade one');
            $response->assertViewHas('subjectContents', fn ($chapters) => $chapters->isEmpty());
            $response->assertDontSee('id="main-video"', false);
        }
    }

    public function test_unknown_grade_subject_pair_returns_not_found(): void
    {
        $this->get($this->subjectUrl('en', 999))->assertNotFound();
    }

    public function test_book_links_allow_local_paths_and_http_but_reject_script_urls(): void
    {
        DB::table('chapters')->insert([
            ['id' => 1, 'subject_id' => 1, 'grade_id' => 1, 'name' => 'One', 'number' => '1'],
            ['id' => 2, 'subject_id' => 1, 'grade_id' => 1, 'name' => 'Two', 'number' => '2'],
            ['id' => 3, 'subject_id' => 1, 'grade_id' => 1, 'name' => 'Three', 'number' => '3'],
        ]);
        DB::table('subject_lessons')->insert([
            ['id' => 1, 'chapter_id' => 1, 'title' => 'Unsafe', 'body' => 'javascript:alert(1)', 'type' => 'file'],
            ['id' => 2, 'chapter_id' => 2, 'title' => 'External', 'body' => 'https://example.com/book.pdf', 'type' => 'file'],
            ['id' => 3, 'chapter_id' => 3, 'title' => 'Missing book', 'body' => 'storage/uploads/missing.pdf', 'type' => 'file'],
        ]);

        $this->get($this->subjectUrl())->assertOk()->assertViewHas('subjectContents', function ($chapters) {
            return $chapters[0]->book_url === null
                && $chapters[1]->book_url === 'https://example.com/book.pdf'
                && $chapters[2]->book_url === null;
        });
    }

    private function subjectUrl(string $language = 'en', int $grade = 1): string
    {
        return 'http://'.config('app.app_url_domain').'/'.$language.'/grade/'.$grade.'/subject/1';
    }
}
