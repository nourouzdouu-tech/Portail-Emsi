<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\Cv;
use App\Models\Letter;

class DocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $cvs = Cv::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $letters = Letter::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $documents = Document::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'cvs' => $cvs,
            'letters' => $letters,
            'documents' => $documents
        ]);
    }
    
    public function upload(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:pdf,docx|max:5120', // 5MB max
            'document_type' => 'required|in:cv,letter',
            'document_name' => 'nullable|string|max:255'
        ]);
        
        $user = Auth::user();
        $uploadedFiles = [];
        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents/' . $user->id, $filename, 'public');
                
                $document = Document::create([
                    'user_id' => $user->id,
                    'name' => $request->document_name ?: $file->getClientOriginalName(),
                    'type' => $request->document_type,
                    'filename' => $filename,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'status' => 'uploaded'
                ]);
                
                $uploadedFiles[] = $document;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Documents uploadés avec succès',
            'files' => $uploadedFiles
        ]);
    }
    
    public function preview($id, Request $request)
    {
        $type = $request->get('type');
        $user = Auth::user();
        
        if ($type === 'cv') {
            $cv = Cv::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            return $this->generateCvPreview($cv);
        } elseif ($type === 'letter') {
            $letter = Letter::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            return $this->generateLetterPreview($letter);
        } else {
            $document = Document::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            return $this->generateDocumentPreview($document);
        }
    }
    
    public function edit($id, Request $request)
    {
        $type = $request->get('type');
        $user = Auth::user();
        
        if ($type === 'cv') {
            $cv = Cv::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            return response()->json($cv);
        } elseif ($type === 'letter') {
            $letter = Letter::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            return response()->json($letter);
        } else {
            $document = Document::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            return response()->json($document);
        }
    }
    
    public function update($id, Request $request)
    {
        $user = Auth::user();
        
        // Déterminer le type de document basé sur les champs présents
        if ($request->has('first_name') || $request->has('last_name')) {
            // C'est un CV
            $cv = Cv::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            $cv->update($request->all());
            return response()->json(['success' => true, 'message' => 'CV mis à jour']);
        } elseif ($request->has('title') && $request->has('content')) {
            // C'est une lettre
            $letter = Letter::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            $letter->update($request->all());
            return response()->json(['success' => true, 'message' => 'Lettre mise à jour']);
        } else {
            // Document générique
            $document = Document::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            $document->update($request->all());
            return response()->json(['success' => true, 'message' => 'Document mis à jour']);
        }
    }
    
    public function destroy($id)
    {
        $user = Auth::user();
        
        // Essayer de supprimer dans tous les types de documents
        $deleted = false;
        
        // CV
        $cv = Cv::where('id', $id)->where('user_id', $user->id)->first();
        if ($cv) {
            $cv->delete();
            $deleted = true;
        }
        
        // Letter
        $letter = Letter::where('id', $id)->where('user_id', $user->id)->first();
        if ($letter) {
            $letter->delete();
            $deleted = true;
        }
        
        // Document
        $document = Document::where('id', $id)->where('user_id', $user->id)->first();
        if ($document) {
            // Supprimer le fichier physique
            if (Storage::disk('public')->exists($document->path)) {
                Storage::disk('public')->delete($document->path);
            }
            $document->delete();
            $deleted = true;
        }
        
        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Document supprimé']);
        }
        
        return response()->json(['success' => false, 'message' => 'Document non trouvé'], 404);
    }
    
    public function download($id)
    {
        $user = Auth::user();
        $document = Document::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        
        $filePath = storage_path('app/public/' . $document->path);
        
        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }
        
        return response()->download($filePath, $document->name);
    }
    
    private function generateCvPreview($cv)
    {
        $experiences = json_decode($cv->experiences, true) ?? [];
        $skills = explode(',', $cv->skills ?? '');
        
        $html = "
        <div style='font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;'>
            <div style='text-align: center; margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #22c55e, #10b981); color: white; border-radius: 10px;'>
                <h1 style='margin: 0; font-size: 2.5em;'>{$cv->first_name} {$cv->last_name}</h1>
                <h3 style='margin: 10px 0; opacity: 0.9;'>{$cv->job_title}</h3>
                <p style='margin: 5px 0;'>{$cv->email} | {$cv->phone}</p>
            </div>
            
            <div style='margin-bottom: 25px;'>
                <h3 style='color: #16a34a; border-bottom: 2px solid #22c55e; padding-bottom: 5px;'>Profil Professionnel</h3>
                <p style='line-height: 1.6; text-align: justify;'>{$cv->profile}</p>
            </div>";
            
        if (!empty($experiences)) {
            $html .= "
            <div style='margin-bottom: 25px;'>
                <h3 style='color: #16a34a; border-bottom: 2px solid #22c55e; padding-bottom: 5px;'>Expériences Professionnelles</h3>";
            
            foreach ($experiences as $exp) {
                if (!empty($exp['title'])) {
                    $html .= "
                    <div style='margin-bottom: 20px; padding: 15px; background: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 5px;'>
                        <h4 style='margin: 0 0 5px 0; color: #166534;'>{$exp['title']}</h4>
                        <p style='margin: 0 0 5px 0; font-weight: bold; color: #16a34a;'>{$exp['company']} | {$exp['period']}</p>
                        <p style='margin: 0; line-height: 1.5;'>{$exp['description']}</p>
                    </div>";
                }
            }
            $html .= "</div>";
        }
        
        if (!empty($skills)) {
            $html .= "
            <div style='margin-bottom: 25px;'>
                <h3 style='color: #16a34a; border-bottom: 2px solid #22c55e; padding-bottom: 5px;'>Compétences</h3>
                <div style='display: flex; flex-wrap: wrap; gap: 10px;'>";
            
            foreach ($skills as $skill) {
                $skill = trim($skill);
                if (!empty($skill)) {
                    $html .= "<span style='background: #dcfce7; color: #166534; padding: 5px 15px; border-radius: 20px; font-size: 0.9em;'>{$skill}</span>";
                }
            }
            $html .= "</div></div>";
        }
        
        $html .= "</div>";
        
        return $html;
    }
    
    private function generateLetterPreview($letter)
    {
        $html = "
        <div style='font-family: Arial, sans-serif; max-width: 700px; margin: 0 auto; padding: 40px; line-height: 1.8;'>
            <div style='text-align: right; margin-bottom: 40px; color: #666;'>
                " . date('d/m/Y') . "
            </div>
            
            <div style='margin-bottom: 30px;'>
                <strong>Objet :</strong> {$letter->title}
            </div>";
            
        if ($letter->company) {
            $html .= "
            <div style='margin-bottom: 30px;'>
                <strong>À l'attention de :</strong><br>
                {$letter->company}
            </div>";
        }
        
        $html .= "
            <div style='text-align: justify;'>
                {$letter->content}
            </div>
            
            <div style='margin-top: 40px; text-align: right;'>
                <p><strong>" . Auth::user()->name . "</strong></p>
            </div>
        </div>";
        
        return $html;
    }
    
    private function generateDocumentPreview($document)
    {
        return "
        <div style='text-align: center; padding: 50px;'>
            <i class='fas fa-file-alt' style='font-size: 4em; color: #22c55e; margin-bottom: 20px;'></i>
            <h3>{$document->name}</h3>
            <p>Type: " . strtoupper($document->mime_type) . "</p>
            <p>Taille: " . $this->formatBytes($document->size) . "</p>
            <p>Uploadé le: " . $document->created_at->format('d/m/Y à H:i') . "</p>
            <a href='" . Storage::url($document->path) . "' target='_blank' class='btn btn-primary'>
                <i class='fas fa-external-link-alt'></i> Ouvrir le fichier
            </a>
        </div>";
    }
    
    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
