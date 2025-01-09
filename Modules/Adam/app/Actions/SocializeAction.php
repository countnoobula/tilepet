<?php

namespace Modules\Adam\Actions;

use Modules\Adam\Models\Noob;
use Modules\Adam\Events\NoobSocialized;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocializeAction implements ActionInterface
{
    /**
     * Execute the socialize action.
     *
     * @param array $parameters
     * @return void
     */
    public function execute(array $parameters): void
    {
        $noobId = $parameters['noob_id'] ?? null;
        $targetNoobId = $parameters['target_noob_id'] ?? null;

        if (!$noobId || !$targetNoobId) {
            Log::warning("Invalid parameters for SocializeAction: " . json_encode($parameters));
            return;
        }

        DB::transaction(function () use ($noobId, $targetNoobId, $parameters) {
            $noob = Noob::find($noobId);
            $targetNoob = Noob::find($targetNoobId);

            if (!$noob || !$targetNoob) {
                Log::warning("Noob(s) not found for SocializeAction. Noob ID: {$noobId}, Target Noob ID: {$targetNoobId}");
                return;
            }

            // Implement social interaction logic
            $noob->social = min(100, $noob->social + 10);
            $targetNoob->social = min(100, $targetNoob->social + 10);
            $noob->save();
            $targetNoob->save();

            // Trigger event with LLM response included
            event(new NoobSocialized($noob, $targetNoob, $parameters));
        });
    }
}
