<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $categories = [
            'full-time' => 'Full-time',
            'part-time' => 'Part-time',
            'contract' => 'Contract',
            'temporary' => 'Temporary',
            'internship' => 'Internship',
            'volunteer' => 'Volunteer',
        ];
        $query = \App\Models\JobPosting::where('status', 'published');
        if (request('keyword')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%'.request('keyword').'%')
                  ->orWhere('description', 'like', '%'.request('keyword').'%');
            });
        }
        if (request('location')) {
            $query->where('location', 'like', '%'.request('location').'%');
        }
        $latestJobs = $query->latest()->take(10)->get();
        $topCompanies = [
            [
                'name' => 'Tech Innovators',
                'logo' => 'https://ui-avatars.com/api/?name=Tech+Innovators&background=0D8ABC&color=fff',
                'industry' => 'IT & Software',
                'rating' => 5,
            ],
            [
                'name' => 'HealthFirst',
                'logo' => 'https://ui-avatars.com/api/?name=HealthFirst&background=28a745&color=fff',
                'industry' => 'Healthcare',
                'rating' => 4,
            ],
        ];
        return view('public.home', compact('latestJobs', 'categories', 'topCompanies'));
    }
    
}
