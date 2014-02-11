StreamIteratorInterface
=======================
Defines what a stream iterator needs to make public!

Methods
-------
|Methods		|Parameters						|ExpectedBehavior
|---------------|-------------------------------|----------------
|__construct	|								|
|				|$content 						|The content we will create a stream on, highly depends on the type of stream iterator you want to do
|				|BehaviorInterface $behavior 	|The behavior the user wants to apply on each iteration
|setContent		|								|Sets the content of the stream and re/initializes it to this new content
|				|$content 						|The content we will create a stream on, highly depends on the type of stream iterator you want to do
|setBehavior	|								|Sets the behavior to apply to the stream iterator on each iteration
|				|BehaviorInterface $behavior	|The behavior the user wants to apply on each iteration
|getBehavior	|								|Returns the behavior being used on each iteration
|getStreamHandle|								|Returns the stream handle being used with this iterator