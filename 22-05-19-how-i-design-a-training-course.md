---
title: How I prepare a training course from scratch
---

I've been working on and off in the field of 'tech industry training' for nearly a decade now. I want to talk about how I make the journey from an initial conversation with a customer to being ready to deliver the training.

I have evolved an top-down outcome-driven method for course design and thought I would give away my secret sauce in the spirit of sharing. I was never formally trained in Education so this probably overlaps with some existing best practices in the field.

Obviously the way I _actually_ do it varies slightly with each engagement, but this is the rough framework.

# Giving some credit

I started doing training with [Marcello Duarte](https://twitter.com/_md) after seeing him deliver some great training at my former company. We worked together for ~5 years and I learned a lot about:

1. Marcello's official, structured, documented, 'how to design training' system
2. The system he _actually_ used
3. Emergency systems that come into play when you're told about something you have to deliver _tomorrow_ in a subject you know _nothing about_

(I learned a lot about delivery during that job too but that's not the main subject of this post)

Another big influence is the way [Cucumber](https://cucumber.io/school/) design and deliver their training.

I've contributed and delivered their BDD courses in-person and online, and their very interactive courses helped me step back from some of the heavily-presentational style I'd been using for my own courses.

In particular co-delivering training with [Matt Wynne](https://twitter.com/mattwynne), and using the excellent trainer notes from [Seb Rose](https://twitter.com/sebrose) have really fed back into my style (also I should plug [Training from the Back of the Room]()).

# What sort of training formats am I talking about?

I'm mostly contacted by people who:
- Want training in a specific area, often technical or process-related
- Are thinking in terms of 'buying some days of training', typically 0.5 to 3 days.
- May want me to 'deliver the course' multiple times across teams.

Long-term I think ongoing coaching tends to be more effective than _just_ training courses, but I tend to conform to those expectations for an initial engagement and offer coaching activities as part of follow-up.

For a new area of practice, a training course from an external authority figure is often be a good way to show commitment from the organisation to a new initiative, and can mark a transitional moment where the team 'starts doing X'.

Incidentally, I tend to think if you're a smart person you can learn any subject well enough to deliver it to a group of learners effectively. The key role of a trainer is to think about how to educate people in a subject clearly, in the right order, and leave them with the right learning outcomes. The skills to do that are subject-agnostic.

I'm going to go through my typical steps in this sort of engagement, with a running worked example of a typical course.

# Step 1. Understanding the expectations

My first goal is to try and understand what's being asked for.

There aren't set questions to ask, but you're trying to get some key understandings. There are two perspectives I want to explore. If I can I'll cover them in one call.

## Talk to a 'boss'

I talk to someone who is approving the spend on the training, but isn't going to attend it.

They'll have a good perspective of what external outcomes will make them willing to spend money and team-time on a piece of training, without it being driven by personal interest in a subject.

It's important to understand:
- What problems do they hope it will address?
- What concrete changes do they hope to see after the training?
- Who would be attending and why?
- What is the overall scope in terms of time and money?

I try and capture real key phrases in my notes. After the call they might look something like this:

> Bob Johnson - development manager - Pyjamas-by-post Ltd
>
> Java team 4 ppl, React team 4 ppl - single product, 2 work streams
>
> Features not being developed at pace would like
>
> Backlog growing 'nothing gets done'
>
> NOT lack of technical skill
>
> 1-2d 'agile training', no budget
>
> Items get dragged from sprint to sprint
>
> 'make sure they are doing it right'
>
> 'see what they can improve'
>
> Ideal outcome: 'things getting unblocked'

The general impression is that there's a slowness/inefficiency in the dev teams that needs to be unblocked

## Talk to a potential attendee

I want to talk someone who is going to come on the course and will have an insider view on why the training is needed.

They can tell me:
- Is the business correct about the problems they have?
- How do _they_ think this subject area will help?
- What other issues could this training solve that aren't visible outside the team?
- What is the current level of knowledge in the relevant areas?
- Who else could benefit from training, who isn't being considered?

Example notes:

> Freya Thorsdottir - team lead Java
>
> 'we do stuff that never gets used'
>
> 2-3 months between Java team complete + FE team complete
>
> 'spend a lot of time working out what we're supposed to be doing'
>
> 'stuff just gets dropped on us' by PM
>
> Scrum-ish proc - planning, stand-ups, review, no retros
>
> No prior agile training
>
> 'requirements don't make sense'

The vibe here is that there are also systematic issues in how work flows into or out of the team that are causing a lot of the problems.

## Follow-up if needed

For a small bit of training this may be enough to go ahead, but if there are large areas of uncertainty or other people referenced who would be useful to talk I would then arrange  some similar follow-up calls.

I just want to get to the level of understanding to be confident in the next step.

# Step 2. Connect business needs to learning outcomes
 
While I still have context from the conversations, I'll try and create a map that links my understanding of the problem with the outcomes of the training.

This is very much 'starting with the end in mind'.

I normally only spend 20 minutes at a time on this whole step, let it rest, then come back fresh later.

I capture this offline or online in various formats. A table is best for this post, but you can imagine a grid of stickies if you prefer. What I want to share really is the order of thinking.

I want to emphasise that I do this very scrappily, then refine it. To prove that, here is a picture taken a few years ago with [Jakub Zalas](https://twitter.com/jakzal)

![Jakub with a table full of stickies and a pint](22-05-19/jakub.jpeg)

We had an in-person meeting with a customer, went for lunch around the corner, and did most of this step on the table. The result was refined and formed the backbone of a 2-day course, delivered across more than 15 teams.

## List the Business's needs

I think about the scope of the problem I've been faced with, what the stated needs were, and what other needs I think may be present.  I then enumerate them in _no particular order_.

From the example conversations I might end up with this (for a small example):

| Needs | 
|:------|
| More collaboration between Java and FE teams |
| Clearer requirements at sprint start          |
| Improved throughput of work |
| Shorter backlogs |
| Focus on finishing |

## Add appropriate learning outcomes for attendees

Inspired by these needs, I then try and write as many  learning outcomes as I can that would address each need.

I am not too strict about the definition of an outcome, I mostly think of them as a change in the attendees as a result of the course.

If I feel like attendees will be from lots of different roles, I will also capture those. If it's a room full of developers I'd skip it.

I don't write it out this way, but you could think of it as:

```
Given I am a <role>
When I attend this course
Then I <outcome>
And that will contribute to <business need>
```

While writing them I'm considering the existing knowledge level of attendees, and what seems practical to achieve.

For instance for a training course aimed at experienced Ops professionals, an achievable goal of the training might be:

> Can apply a service mesh to their existing Kubernetes deployment

… implying that they'll leave the course ready to do it in their next sprint.

For a less experienced group, or if it's one subject amongst many, I might write:

> Knows what a service mesh is, and can explain the benefits of using one

… where the aim of the course is to introduce a concept and give them some motivation towards learning more.

I capture the understanding in two new columns (working right-to-left):

| Target learners | Outcomes | Needs |
|:------|
| Delivery teams and product stakeholders | Can describe how 'shifting left' promotes shared understanding | More collaboration between Java and FE teams |
| Delivery teams and product stakeholders | Can list the key characteristics of a clear requirements document | Clearer requirements at sprint start  |
| Delivery teams and product stakeholders | Can name five ways to slice a feature  | Clearer requirements at sprint start  |
| Delivery teams and product stakeholders | Can take part in an effective backlog review | Clearer requirements at sprint start          |
| Delivery teams | Can explain why limiting work in progress improves flow | Improved throughput of work |
| Delivery teams | Know why it's important to keep backlogs short | Shorter backlogs |
| Delivery teams | Have a shared understanding of what backlogs exist and their appropriate sizes | Shorter backlogs |
| Delivery teams | Have a way to measure business impact of work vs effort | Focus on finishing |
| Delivery teams | Understand the importance of slack time to increase responsiveness | Focus on finishing |

## Shuffle and refine

Once I run out of ideas, I try to narrow the options down and shuffle things around into an order that:

- seems like it's telling a story - introducing concepts in the right order
- groups together subjects that some attendees could skip
- gives some idea of how it would be broken into day-length blocks

I'll try out different arrangements of the ideas, working out which to take out to fit if there feels like too much.

I'll add/reword/remove stuff as I go, to try and get to an achievable set of goals for the course length constraints.

I continue to work right-to-left, merging the role+dates columns as it gets concrete

| Day | Outcomes | Needs |
|:------|
| 1 (All) | Can describe how 'shifting left' promotes shared understanding | More collaboration between Java and FE teams |
|  | Can name five ways to slice a feature  | Clearer requirements at sprint start  |
|  | Can take part in an effective backlog review | Clearer requirements at sprint start          |
| 2 (Delivery teams) | Know why it's important to keep backlogs short | Shorter backlogs |
|  | Have a shared understanding of what backlogs exist and their appropriate sizes | Shorter backlogs |
|  | Be able to measure and identify bottlenecks in their progress | Focus on finishing |
|  | Understand the importance of slack time to increase responsiveness | Focus on finishing |

# Step 3. Pitch it!

This is the point at which I'd send an email proposal of the training.

I _do not_ drill into the specific activities, no least because they're not set yet.

There are a couple reasons I prefer to pitch at this level.

Firstly, I design bespoke training and really try to tailor it to the customer. I can't therefore afford to design a course in explicit detail before they've committed to go ahead.

That consideration won't apply as much if it's a course you're designing to deliver repeatedly (e.g. a regularly-run public course).

At this point in my career I trust myself to be able to build a course that fulfils the outcomes in the time available.

If it was an area entirely outside my knowledge, or I was a less experienced in training, I might do more of the later steps before pitching.

Secondly, when the customer is making a purchasing decision I want the benefits they'll get to be front and centre. I want them to be considering:

> "Do I want to pay £££ to get these outcomes for the team?"

Rather than thinking:

> "Do I want to pay this guy £££ to run these activities?"

For that reason, even if you've gone through the next steps to build your own confidence, I'd still only pitch on the outcomes.

My emails are fairly casual, and directly inspired by my meeting notes and the outline so far, with some accommodations to match the recipient's language:

```
Hi Bob

Thanks to you and Freja for your time, I think I've got a good understanding of the key challenges you are facing:

 - The backlog of work is increasing, but you don't think the bottlenecks are technical
 - Items are started and not finished for some time later
 - The sprints are not regularly delivering value

The training would aim to:
 - Increase the effectiveness of hand-off between Java and FE teams
 - Improve the clarity of requirements to reduce misunderstandings and waste
 - Focus the team on finishing work in progress instead of taking on more

I suggest we deliver 2-day course around Agile topics with some BDD themes that would address some of your specific issues, with non-technical roles involved heavily in day 1.

Title: Agile Product Development

Day 1: The two delivery teams, Product Owner, BAs

Attendees will learn how to:
 - describe how earlier collaboration promotes a shared understanding of requirements
 - slice a feature into smaller achievable chunks, using a appropriate strategies
 - have effective backlog reviews to ensure clear requirements at sprint start
 
Day 2: The two delivery teams only

After this day attendees will:
 - understand why shorter backlogs improve responsively
 - have a clear model of how work moves through the various backlogs of the delivery team processes
 - be able to identify and unblock bottlenecks in the delivery team
 
For this, [COMMERCIAL DETAILS GO HERE, NEAR TO BENEFITS]

Please let me know how you want to proceed.
```

There may be some back-and-forth at this stage about the outcomes if they don't quite match what the customer had in mind, but this is where you'll get a thumbs up or down.

# Step 4. Design the outline

You have from the time the client replies with a 'yes' until the day of delivery to design the training activities.

It's a good idea not to be doing it the night before.

I use a top-down approach and try to get to a reasonable outline first before drilling in too much.

A big reason for this is that the outline will help me see more clearly what work needs to be done to get the course ready.

I'm going to present it pretty linearly, but please understand the actual process is much more iterative than this will look - you will go over it a bunch of times, cross things out, go down rabbit holes and undo the lot. That's fine - nobody will ever see it but you!

## Validate the outcomes with checkpoints

For each of the agreed learning outcomes, I then try to think of an activity the learner will take part in that will validate the learning outcome. Often it's as simple as:

* For some _knowledge they've gained_, you want an activity where they _recall the knowledge_ in some way
* For a _a skill they learn_, you want an activity where they _use the skill_
* For a thing you want them to be _feel able to do_, you want something where they _relate it to their real context_

There are endless variations on what activities to design, we won't explore them in this article but focus on the structure.

While doing this I consider how to get a mix of activities through each day, and what the attendees' energy levels will be like at each stage.

I merge the day and roles as they're now fixed, but continue to mostly work right-to-left from the learning outcomes.

Timings will change as you tweak the plan, and _will_ be different on the day!  They're only here as a check of the realism of the plan - resist the urge to put the actual times of day in.

(From here on I'm only going to show a horizontal slice of the outline; there would be more before and after each example)

| Day | Timings | Checkpoints | Outcomes | Needs |
|:------|
| 1 (all) |  30 mins  |  Review a backlog in groups |Can take part in an effective backlog review | Clearer requirements at sprint start |


## Plan how to get the learners ready for each checkpoint

I then think about each checkpoint, and consider how I could get the learner to the stage where they are ready for that exercise?

Connecting learning closely to an imminent checkpoint puts me in the learner's position and lets me ask 'what would I need to see/hear/do/explore, to be able to do that?'

I allow myself to be vague on some of the activities and focus more on what _type_ of activity would be useful for that _sort_ of learning at first.

As with checkpoints you're still trying to shape the day and keep some variety of activity on the part of the learners.

I capture the activities in my table. I am still broadly working right-to-left, but I keep the timings on the right and I'll place the learning activities above the checkpoints they relate to, so it's becoming more like an agenda.

I now might start to think about where breaks and lunch would naturally fit, and check that I'm not putting too much into each day.

Timings are still approximate and exercises or discussions can flex, so don't be too worried about the detail.

As a general rule I'd probably not put more than 6 hours in a day, at an absolute maximum. It's better to have less, and more time for side-discussions.

| Day |  Timings | Activities | Checkpoints | Outcomes | Needs |
|:------|
| 1 (all) |  ??  | Presentation - introduce concept of Definition of Ready |   |  |  |
|  |  15 mins  |  Discussion in pairs with prompts - designing a DoR | |  |  |
|  |  30 mins  | | Practice backlog review session | Can take part in an effective backlog review | Clearer requirements at sprint start |

I sometimes check that it makes sense by using a sentence:

> If I explain what definition of ready is, and they get a chance to create one, they'll be ready to use one in a backlog review

## Capture the prep needed for each activity

This is where I start to build an idea of the work I need to do before delivering this course. For each Activity or Checkpoint I try and capture:

- What thinking or research do I need to do in advance?
- What prepared material do I need to create to take with me?

Of course at this stage I may not know, it's fine to put a question mark or a vague comment. I'm trying to understand whereto gaps are too.

| Day |  Timings | Prep | Activities | Checkpoints | Outcomes | Needs |
|:------|
| 1 (all) |  ??  | Define the key points to cover | Presentation - introduce concept of Definition of Ready |   |  |  |
|  |  15 mins  | Generate the discussion prompts |  Discussion in pairs with prompts - designing a DoR | |  |  |
|  |  30 mins  | Tweak what we did on the Widgets-R-Us training | |  Practice backlog review session | Can take part in an effective backlog review | Clearer requirements at sprint start |

## Capture the materials needed

The outline should also make it clear what pre-prepared material I need to have generated or retrieved before I can deliver the training.

For some courses I will be able to go along with just a head full of ideas:

| Timings | Prep | Materials | Activities | Checkpoints | Outcomes | Needs |
|:------|
| most of the morning | Pick an example business domain | The usual set of stickies and sharpies | Event storming | |  |
| half hour before lunch |  |  |  | 1,2,4 all - what is unclear about the process? Answer where possible | Can take part in a big picture event storming session  | Improved understanding of business processes |

For other subjects I'll need at least some level of written material, diagrams, and prompts:

| Timings | Prep | Materials | Activities | Checkpoints | Outcomes | Needs |
|:------|
| ??  | Define the key points to cover | Key points in trainer notes | Presentation - introduce concept of Definition of Ready |   |  |  |
| 15 mins  | Generate the discussion prompts | Written prompts in workbooks  | Discussion in pairs with prompts - designing a DoR | |  |  |
| 30 mins  | Tweak what we did on the Widgets-R-Us training | Example backlog items on A5 (print 4-per-page on A4 and cut). 4 sets? | |  Practice backlog review session | Can take part in an effective backlog review | Clearer requirements at sprint start |

I'll continue to edit the outline, but there is a point where it's in a good enough shape that the level of preparation effort required from me is very clear.

I want to get to this point soon after agreement with the customer, so I can judge were the pre-work fits with my other ongoing work.

# Step 5. Get it all ready

I now have a To-Do list of Prep and Materials to cover between now and delivery.

The items I try to focus on first are the ones with the most uncertainty, for instance designing a new exercise or presenting a complex subject that I'm not confident in.

For exercises in particular, I find if I wait a few days/weeks after generating the outline more ideas will naturally pop into my head, but often having written the outline my subconscious is already working on it.

The second focus is the areas that are clear, but require lots of preparation, for instance slides with lots of references, or an example codebase + clear steps for an exercise.

I do my best to schedule these into my calendar in blocks where I'll crank through them. It's not a bad idea to try and generate a less-prep alternative for each to keep in your back pocket.

## Writing good trainer notes

There is one thing I create fairly directly from the outline, and that's my notes. I tend to have them on paper, and as a PDF on my tablet just in case.

I take the materials column from the outline and convert it into a packing list for the training and put that on page one. This is the thing I'll be checking and double-checking before the engagement.

```
Materials Checklist:
  * 1 trainer notes (backup on tablet)
  * Tablet charged
  * 12 learner workbooks
  * 20 sharpies 
  * Posters (drawn on flip chart):
    * Definition of ready
    * ...
  * Printed Example Backlog items x 4
  * ...
```

The rest of the notes very follow the structure of the outline, with more detail added:

```markdown
# Day 1, Morning
# Can hold a collaborative backlog review

## Introduce concept of Definition of Ready - 10 min

 - Ask if they have heard 'Definition of Done'? If they have get a definition and ask how it helps

- Write DoR on whiteboard, either using terms reflecting the DoD definition or:

> "An agreed definition of what stories need, to be available and up for discussion on the sprint planning meeting"

 * Ask what think it means. Clarify.

## Discussion - 20-30 min

Prep: check everyone has a workbook

Organise into pairs and indicate prompts on workbook page 2

*Prepare next exercise during this*

At end of time capture 'key points' from each pair on flipchart

## Backlog Review Exercise - 20 min

Prep: cut out and sort backlog items into 4 piles

Organise into 4 groups, give each group a set of backlog items, explain the exercise:

[... and so on ...]

```


The important thing is for my notes to be easily navigable in a rush. I will want to have them in the correct order of delivery and make it very easy to find what I'm doing _now_ and what I should be getting ready for _next_.

For this reason I try to use a lot of whitespace with many pages, rather than cramming multiple blocks onto the same page.

For areas I'm comfortable discussing it's fine for example to have a 20-min block that just says "Explain how to draw an owl". I would want to have the key points written down to refer to (e.g. "The trick with the curve of the beak").

# Step 6. Deliver!

This is a whole other part of the secret recipe! If I have my notes, and all the materials on the list, I should be in a good place psychologically.

At any point where the focus is off me, I look at the notes and think about:

- What did I plan to doing next?
- Am I ready? Is there some prep needed that I could be doing now?
- What time is it? Am I where we expected to be? Is there something to re-plan? Should I let some activities run longer, or skip some?
- What is the group's energy? Do I want to bring anything forwards or backwards to match that?
- What have I been hearing? Is there an opportunity to match the course even better to the business needs?

I've come to believe that sort thinking, while the learners are doing an activity that will help them learn, is a more valuable use of trainer time and expertise than presentational stuff.

# Step 7. Do it all over again

The amount of prep reduces with each course I do in a similar area because elements can be reused, but I do always try and have a bespoke course addressing the specific needs of the learners.

I find prep very daunting, laborious, and a source of procrastination. That's why I've ended up with a fairly robust stepwise process to get me through it, and get to an outline fast. I hope explaining my method has helped you, even if your reaction is "I won't do it like that"!

Actually delivering training is one of the most enjoyable, energising, and exhausting aspects of my job. I hope you find it as rewarding as I do.
