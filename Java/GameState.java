package com.vyperz.skywars.fr;

public enum GameState {
	
	LOBBY,
	GAME,
	END;
	
	private static GameState currentState;
	
	GameState(){
	}
	
	public static void setState(GameState state){
		GameState.currentState = state;
	}
	
	public static boolean isState(GameState state){
		return GameState.currentState == state;
	}
	
	public static GameState getState(){
		return currentState;
	}

}