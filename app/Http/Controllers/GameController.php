<?php

namespace App\Http\Controllers;

use App\Personnage;
use App\TypePersonnage;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private static $ATTAQUE_NORMALE_GOBELIN = 5;
    private static $ATTAQUE_SUPERIEUR_GOBELIN = 10;
    private static $ATTAQUE_SUPERIEUR_GOBELIN_PERTE_LP = 3;
    private static $ATTAQUE_POISON_SORCIERE = 3;
    private static $ATTAQUE_POISON_SORCIERE_PERTE_LP = 3;
    private static $SOIN_SORCIERE = 4;
    private static $ATTAQUE_NORMALE_ORC = 5;
    private static $MAX_LP = 100;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnagesCount = Personnage::count();
        $gameOver = Personnage::where('lp', '<>', 0)->count() == 0;
        $personnages = Personnage::with('typePersonnage')->get();
        return view('game.index', compact('personnagesCount', 'personnages', 'gameOver'));
    }

    public function doTurn() {
        $personnages = Personnage::with('typePersonnage')->get();
        $this->doAttack();
        return redirect()->to(route('game'));
    }

    public function reset() {
        $personnages = Personnage::all();
        foreach ($personnages as $personne) {
            $this->updatePerson($personne, self::$MAX_LP);
        }
        return redirect()->to(route('game'));
    }

    private function doAttack() {
        $personnageEnnemi = Personnage::inRandomOrder()->first();
        $personnageAttacker = Personnage::inRandomOrder()->where('id','<>', $personnageEnnemi->id)->first();
        $randomAttackSpecial = rand(0,1) == 1;

        $typePersonnageAttacker = $personnageAttacker->type_personnage_id;

        switch ($typePersonnageAttacker) {
            case TypePersonnage::$GOBELIN:
                if ($randomAttackSpecial) {
                    $lp = 0;
                    if($this->areEnoughLP($personnageAttacker, self::$ATTAQUE_SUPERIEUR_GOBELIN_PERTE_LP)) {
                        $lp = $personnageAttacker->lp-self::$ATTAQUE_SUPERIEUR_GOBELIN_PERTE_LP;
                    }
                    $this->updatePerson($personnageAttacker, $lp);

                    $lp = 0;
                    if($this->areEnoughLP($personnageEnnemi, self::$ATTAQUE_SUPERIEUR_GOBELIN)) {
                        $lp = $personnageEnnemi->lp-self::$ATTAQUE_SUPERIEUR_GOBELIN;
                    }
                    $this->updatePerson($personnageEnnemi, $lp);
                } else {
                    $lp = 0;
                    if($this->areEnoughLP($personnageEnnemi, self::$ATTAQUE_NORMALE_GOBELIN)) {
                        $lp = $personnageEnnemi->lp-self::$ATTAQUE_NORMALE_GOBELIN;
                    }
                    $this->updatePerson($personnageEnnemi, $lp);
                }
                break;
            case TypePersonnage::$SORCIERE:
                if ($randomAttackSpecial) {
                    $lp = 0;
                    if($this->areEnoughLP($personnageAttacker, self::$ATTAQUE_POISON_SORCIERE_PERTE_LP)) {
                        $lp = $personnageAttacker->lp-self::$ATTAQUE_POISON_SORCIERE_PERTE_LP;
                    }
                    $this->updatePerson($personnageAttacker, $lp);

                    $lp = 0;
                    if($this->areEnoughLP($personnageEnnemi, self::$ATTAQUE_POISON_SORCIERE)) {
                        $lp = $personnageEnnemi->lp-self::$ATTAQUE_POISON_SORCIERE;
                    }
                    $this->updatePerson($personnageEnnemi, $lp);
                } else {
                    $lp = 0;
                    if($this->areEnoughLP($personnageEnnemi, -self::$SOIN_SORCIERE)) {
                        $lp = $personnageEnnemi->lp+self::$SOIN_SORCIERE;
                    }
                    $this->updatePerson($personnageEnnemi, $lp);
                }
                break;
            case TypePersonnage::$ORC:
                $lp = 0;
                if($this->areEnoughLP($personnageEnnemi, self::$ATTAQUE_NORMALE_ORC)) {
                    $lp = $personnageEnnemi->lp-self::$ATTAQUE_NORMALE_ORC;
                }
                $this->updatePerson($personnageEnnemi, $lp);
                break;
        }
    }

    private function updatePerson($personne, $lp) {
        Personnage::where('id', $personne->id)->update(['lp'=> $lp]);
    }

    private function areEnoughLP($personnage, $attack) {
        return $personnage->lp-$attack >= 0;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
