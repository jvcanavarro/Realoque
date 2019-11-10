from kivy.app import App
from kivy.uix.widget import Widget
from kivy.uix.button import Button
from kivy.uix.dropdown import DropDown


class RealoqueDrop(DropDown):
    pass

class RealoqueWid(Widget):
    pass

class RealoqueApp(App):
    def build(self):
        return RealoqueWid()


RealoqueApp().run()
