from kivy.app import App
from kivy.uix.widget import Widget


class RealoqueWid(Widget):
    pass


class RealoqueApp(App):
    def build(self):
        return RealoqueWid()


if __name__ == '__main__':
    RealoqueApp().run()
