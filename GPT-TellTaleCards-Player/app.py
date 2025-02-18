import sys
import os
import openai
import json
import copy
from difflib import SequenceMatcher


from flask import Flask, request, render_template

openai.api_key = os.environ['OPENAIKEY']
 
app = Flask(__name__)  
 
@app.route('/', methods =["GET", "POST"])
def new_gpt_request():
    if request.method == "POST":
        # Collecting story element items from the website form
        story_element1 = request.form.get("firstStoryElement")
        story_element2 = request.form.get("secondStoryElement")
        story_element3 = request.form.get("thirdStoryElement")

        literary_elements_list = request.form.getlist("literary_elements")
        user_story = request.form.get("input_story")
        # Constructing the prompt for GPT-3.5 -- adding the required story elements
        first_sentence = "Write a coherent story that uses some interpretation of " + story_element1 + ", some interpretation of " + story_element2 + ", and some interpretation of " + story_element3 + ". "
        # Constructing the prompt for GPT-3.5 -- adding the required narrative devices
        second_sentences = ""
        for this_literary_element in literary_elements_list:
            if this_literary_element == "conflict":
                second_sentences += "Also the story must have narrative conflict. "
            if this_literary_element == "suspense":
                second_sentences += "Also the story must have narrative suspense. The story having narrative suspense means the story should have a situation where the reader knows something that the characters do not know, making the reader fear for the character. "
            if this_literary_element == "foreshadowing":
                second_sentences += "Also the story must have narrative foreshadowing. The story having narrative foreshadowing means the story should have some object, situation, or plot point that hints at what will happen in the future. "
            if this_literary_element == "flashback":
                second_sentences += "Also the story must have narrative flashbacks. The story having narrative flashbacks means the story should reference something that occurred earlier in the story. "
            if this_literary_element == "plottwist":
                second_sentences += "Also, the story must have a plot twist. The story having a plot twist means the story should have a sudden reveal that changes how the reader views a character or plot point. "
            if this_literary_element == "imagery":
                second_sentences += "Also, the story must have imagery. The story having imagery means the story should have visually vivid and figurative descriptions. "
            if this_literary_element == "personification":
                second_sentences += "Also, the story must have personification. The story having personification means the story should include descriptions of objects where the object is described as having human-like attributes. "
        final_prompt = first_sentence + second_sentences

        # Calling to GPT-3.5 to write the story
        gpt_story_convo = [{"role": "user", "content": final_prompt}]
        gpt_story_response = openai.ChatCompletion.create(model="gpt-3.5-turbo", messages=gpt_story_convo, temperature=0.7)
        gpt_story = gpt_story_response["choices"][0]["message"]["content"]

        # Calling to GPT-3.5 to evaluate the user's story based on the story elements / literary devices as described above
        user_eval_input = "Evaluate the following story based on how well it follows the given prompt and give a score out of ten. The Prompt: [" + final_prompt + "]. The Story: [" + user_story + "]."
        user_eval_convo = [{"role": "user", "content": user_eval_input}]
        user_eval_response = openai.ChatCompletion.create(model="gpt-3.5-turbo", messages=user_eval_convo, temperature=0.7)
        user_eval = user_eval_response["choices"][0]["message"]["content"]

        # Calling to GPT-3.5 to evaluate its own story based on the story elements / literary devices as described above
        gpt_eval_input = "Evaluate the following story based on how well it follows the given prompt and give a score out of ten. The Prompt: [" + final_prompt + "]. The Story: [" + gpt_story + "]."
        gpt_eval_convo = [{"role": "user", "content": gpt_eval_input}]
        gpt_eval_response = openai.ChatCompletion.create(model="gpt-3.5-turbo", messages=gpt_eval_convo, temperature=0.7)
        gpt_eval = gpt_eval_response["choices"][0]["message"]["content"]

        # Rendering information for the website:
        lit_element_string = "<br><h2>Literary Features</h2> <ul>"
        for this_lit_element in literary_elements_list:
            lit_element_string += "<li>" + this_lit_element + "</li>"
        lit_element_string += "</ul>"


        return_render_string = "<h3>Make sure to save the following information in the survey:</h3>" + "<br><h2>Story Cards</h2>" + "<ul><li>" + story_element1 + "</li><li>" + story_element2 + "</li><li>" + story_element3 + "</li></ul>" + lit_element_string + "<br><h2>Your Story</h2>" + "<p>" + user_story + "</p>" + "<br><h2>Story Prompt Given to GPT</h2>" + "<p>" + final_prompt + "</p>" + "<br><h2>GPT's Story</h2>" + "<p>" + gpt_story + "</p>" + "<br><h2>Evaluation Prompt Template Given to GPT</h2>" + "<p>" + "Evaluate the following story based on how well it follows the given prompt and give a score out of ten. The Prompt: [Story Prompt Given to GPT]. The Story: [Story Text]." + "</p>" + "<br><h2>GPT's Evaluation of Your Story</h2>" + "<p>" + user_eval + "</p>" + "<br><h2>GPT's Evaluation of GPT's Story</h2>" + "<p>" + gpt_eval + "</p>"

        return return_render_string
    return render_template("index.html")
 
if __name__=='__main__':
   app.run()