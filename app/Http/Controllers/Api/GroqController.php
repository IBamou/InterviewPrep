<?php

// app/Http/Controllers/Api/GroqController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GroqService;
use Illuminate\Http\Request;
use RuntimeException;

class GroqController extends Controller
{
    public function __construct(protected GroqService $groq) {}

    /**
     * Simple chat — send a message, get a reply
     *
     * POST /api/groq/chat
     * Body: { "message": "Hello!" }
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4096',
        ]);

        try {
            $reply = $this->groq->chat(
                userMessage: $request->input('message')
            );

            return response()->json([
                'success' => true,
                'reply'   => $reply,
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Chat with conversation history
     *
     * POST /api/groq/chat/history
     * Body: {
     *   "message": "What's my name?",
     *   "history": [
     *     {"role": "user", "content": "My name is Ahmed."},
     *     {"role": "assistant", "content": "Nice to meet you, Ahmed!"}
     *   ]
     * }
     */
    public function chatHistory(Request $request)
    {
        $request->validate([
            'message'            => 'required|string|max:4096',
            'history'            => 'nullable|array|max:50',
            'history.*.role'     => 'required|in:user,assistant,system',
            'history.*.content'  => 'required|string|max:4096',
        ]);

        try {
            $reply = $this->groq->chat(
                userMessage: $request->input('message'),
                history:     $request->input('history', [])
            );

            return response()->json([
                'success' => true,
                'reply'   => $reply,
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Chat with a system prompt (persona)
     *
     * POST /api/groq/chat/persona
     * Body: {
     *   "message": "Write a haiku",
     *   "system": "You are a poet who only speaks in haiku."
     * }
     */
    public function chatWithPersona(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4096',
            'system'  => 'nullable|string|max:2048',
        ]);

        try {
            $reply = $this->groq->chatWithSystem(
                systemPrompt: $request->input('system', 'You are a helpful assistant.'),
                userMessage:  $request->input('message')
            );

            return response()->json([
                'success' => true,
                'reply'   => $reply,
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Streaming chat (SSE)
     *
     * POST /api/groq/chat/stream
     * Body: { "message": "Tell me a story" }
     */
    public function stream(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4096',
        ]);

        try {
            return $this->groq->chatStream(
                userMessage: $request->input('message'),
                history:     $request->input('history', [])
            );
        } catch (RuntimeException $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * List available models
     *
     * GET /api/groq/models
     */
    public function models()
    {
        try {
            return response()->json([
                'success' => true,
                'models'  => $this->groq->models(),
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
