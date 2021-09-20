## Gidl

This is a personnal exercise to create my own programming language by learning how they're parsed and interpreted. Finding solutions and possibilities without any vendor.

And yes, in PHP.

### Syntax

This is the syntax I would like to express
```
#Objet {
	expose %nom;
	reserve %location;

	!creation(%nom) {
		this.nom = %nom;
		this.location = "Nowhere";
	}

	!getName : {
		>> "Objet";
	}
}

%nom = "Julien";

!test : name @bool {
	out "Hello" + name;
	>> true;
};

%retour = ?test(nom);
%obj = new Objet();
out obj.getName();
```

### What I need to implement

 - [ ] Expressions (1 +|-|*|/ 2)
 - [ ] Strings ("Hello word")
 - [ ] Print some expressions value (out "Hello word", out 3)
 - [ ] Variables (%nom = %x , %nom = 4)
 - [ ] Functions (!test : name, location @bool { >> true;} )
 - [ ] OOP (name Objet { !constructor(...) })