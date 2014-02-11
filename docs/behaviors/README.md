Behaviors
=========
Behaviors are used to actually fetch data from a stream iterator. 

Stream iterators do not perform fetch operations manually but rely on a behavior object to do so. It allows each stream iterator to focus solely on what it has to do, initialize a stream for the user in the most efficient way. Behaviors on the other hand actually fetch the data and return it to the stream iterator for traversing.

For more information on iterators, visit the [iterator documentation section](../iterators).

You can always define new behaviors by following the existing code base and by referring to the [interfaces documentation](../interfaces).

List of behaviors
-----------------
1. [CharacterBehavior](CharacterBehavior.md)
2. [CharacterChunkBehavior](CharacterChunkBehavior.md)
3. [LineBehavior](LineBehavior.md)