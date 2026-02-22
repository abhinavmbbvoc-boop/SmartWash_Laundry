#include <stdio.h> 
#include <string.h> 
void vulnerableFunction(char *userInput) { 
char buffer[10];  // Small buffer size 
strcpy(buffer, userInput);  // No boundary check (unsafe function) 
printf("You entered: %s\n", buffer); 
} 
int main() { 
char input[50]; 
printf("Enter something: "); 
gets(input);  // Unsafe function, can cause buffer overflow 
vulnerableFunction(input); 
return 0; 
}