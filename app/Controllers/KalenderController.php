<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EventModel;

class KalenderController extends Controller
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        helper(['form', 'url']);
    }

    public function index()
    {

        $data['user'] = [
            'id' => session()->get('id'),
            'nama' => session()->get('nama'),
            'nidn' => session()->get('nidn'),
            'nip' => session()->get('nip'),
            'inisial' => session()->get('inisial'),
            'jabatan' => session()->get('jabatan'),
            'universitas' => session()->get('universitas'),
            'fakultas' => session()->get('fakultas'),
            'jurusan' => session()->get('jurusan'),
            'email' => session()->get('email'),
            'username' => session()->get('username'),
            'role' => session()->get('role')
        ];
        return view('kalender', $data);
    }

    public function getEvents()
    {

        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([]);
        }

        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        $userId = session()->get('user_id') ?? 1; // Default to 1 if no session

        $events = $this->eventModel->where('user_id', $userId)
            ->where('start_date >=', $start)
            ->where('start_date <=', $end)
            ->orWhere('end_date >=', $start)
            ->where('end_date <=', $end)
            ->findAll();

        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event['id'],
                'title' => $event['title'],
                'description' => $event['description'],
                'start' => $event['start_date'],
                'end' => $event['end_date'],
                'color' => $event['color'],
                'className' => $event['class_name'],
                'extendedProps' => [
                    'description' => $event['description'],
                    'type' => $event['color'] === '#F43F5E' ? 'deadline' : ($event['color'] === '#6366F1' ? 'research' : ($event['color'] === '#3B82F6' ? 'publication' : ($event['color'] === '#8B5CF6' ? 'hki' : 'other')))
                ]
            ];
        }

        return $this->response->setJSON($formattedEvents);
    }

    public function addEvent()
    {
        // Hanya admin yang bisa menambah event
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk menambah acara'
            ]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'permit_empty',
            'color' => 'permit_empty',
            'class_name' => 'permit_empty',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $validation->getErrors()
            ]);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description') ?? '',
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date') ?? $this->request->getPost('start_date'),
            'color' => $this->request->getPost('color') ?? '#6366F1',
            'class_name' => $this->request->getPost('class_name') ?? 'event-research',
            'user_id' => session()->get('user_id') ?? 1,
        ];

        try {
            if ($this->eventModel->insert($data)) {
                // Catat aktivitas - pindahkan ke sini
                log_activity(session()->get('id'), 'Create', 'Membuat acara baru: ' . $data['title']);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Event added successfully',
                    'event_id' => $this->eventModel->getInsertID()
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to add event',
                    'errors' => $this->eventModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
    }

    public function updateEvent($id)
    {

        // Hanya admin yang bisa mengupdate event
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengupdate acara'
            ]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'permit_empty',
            'color' => 'permit_empty',
            'class_name' => 'permit_empty',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['status' => 'error', 'message' => $validation->getErrors()]);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description') ?? '',
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date') ?? $this->request->getPost('start_date'),
            'color' => $this->request->getPost('color') ?? '#6366F1',
            'class_name' => $this->request->getPost('class_name') ?? 'event-research',
        ];

        try {
            if ($this->eventModel->update($id, $data)) {
                // Catat aktivitas - pindahkan ke sini
                log_activity(session()->get('id'), 'Update', 'Memperbarui acara: ' . $data['title']);

                return $this->response->setJSON(['status' => 'success', 'message' => 'Event updated successfully']);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to update event',
                    'errors' => $this->eventModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteEvent($id)
    {
        // Hanya admin yang bisa menghapus event
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk menghapus acara'
            ]);
        }

        $event = $this->eventModel->find($id);

        if (!$event) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Event not found']);
        }

        try {
            if ($this->eventModel->delete($id)) {
                // Catat aktivitas
                log_activity(session()->get('id'), 'Delete', 'Menghapus acara: ' . $event['title']);
                return $this->response->setJSON(['status' => 'success', 'message' => 'Event deleted successfully']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete event']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
    }
}
