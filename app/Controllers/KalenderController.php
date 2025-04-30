<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\Controller;

class KalenderController extends Controller
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    public function showcalender()
    {
        // Ambil user_id dari session
        $userId = session()->get('user_id');
        
        // Ambil semua event untuk user tersebut
        $events = $this->eventModel->getEventsByUserId($userId);
        
        // Format events untuk FullCalendar
        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event['id'],
                'title' => $event['title'],
                'description' => $event['description'],
                'start' => $event['start_date'] . ($event['start_time'] ? 'T' . $event['start_time'] : ''),
                'end' => $event['end_date'] . ($event['end_time'] ? 'T' . $event['end_time'] : ''),
                'color' => $event['color'],
                'className' => 'event-' . $event['event_type'],
                'extendedProps' => [
                    'description' => $event['description'],
                    'type' => $event['event_type']
                ]
            ];
        }

        $data['events'] = json_encode($formattedEvents);
        return view('kalender', $data);
    }

    public function saveEvent()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        // Ambil data dari JSON request
        $json = $this->request->getJSON();
        
        $data = [
            'title' => $json->title,
            'description' => $json->description,
            'start_date' => $json->start_date,
            'end_date' => $json->end_date,
            'start_time' => $json->start_time,
            'end_time' => $json->end_time,
            'color' => $json->color,
            'event_type' => $json->event_type,
            'user_id' => $userId
        ];

        try {
            $this->eventModel->insert($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Event berhasil disimpan']);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal menyimpan event: ' . $e->getMessage()]);
        }
    }

    public function updateEvent($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        // Pastikan event milik user ini
        $event = $this->eventModel->where('id', $id)->where('user_id', $userId)->first();
        if (!$event) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Event tidak ditemukan']);
        }

        // Ambil data dari JSON request
        $json = $this->request->getJSON();
        
        $data = [
            'title' => $json->title,
            'description' => $json->description,
            'start_date' => $json->start_date,
            'end_date' => $json->end_date,
            'start_time' => $json->start_time,
            'end_time' => $json->end_time,
            'color' => $json->color,
            'event_type' => $json->event_type
        ];

        try {
            $this->eventModel->update($id, $data);
            return $this->response->setJSON(['success' => true, 'message' => 'Event berhasil diupdate']);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal mengupdate event: ' . $e->getMessage()]);
        }
    }

    public function deleteEvent($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        // Pastikan event milik user ini
        $event = $this->eventModel->where('id', $id)->where('user_id', $userId)->first();
        if (!$event) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Event tidak ditemukan']);
        }

        try {
            $this->eventModel->delete($id);
            return $this->response->setJSON(['success' => true, 'message' => 'Event berhasil dihapus']);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal menghapus event: ' . $e->getMessage()]);
        }
    }
}
